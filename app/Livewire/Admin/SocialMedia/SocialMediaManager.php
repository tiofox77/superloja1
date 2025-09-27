<?php

declare(strict_types=1);

namespace App\Livewire\Admin\SocialMedia;

use App\Models\Product;
use App\Models\SocialMediaPost;
use App\Models\SocialMediaAccount;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use OpenAI\Laravel\Facades\OpenAI;

class SocialMediaManager extends Component
{
    use WithPagination;

    public $showModal = false;
    public $editMode = false;
    public $selectedPost = null;

    // Form fields
    public $platform = 'facebook';
    public $content = '';
    public $images = [];
    public $scheduled_at = '';
    public $status = 'draft';
    public $auto_hashtags = true;
    public $use_ai_content = false;
    public $product_ids = [];

    // AI Settings
    public $ai_tone = 'friendly';
    public $ai_style = 'promotional';
    public $ai_language = 'portuguese';

    // Filters
    public $search = '';
    public $filterPlatform = '';
    public $filterStatus = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    protected $rules = [
        'platform' => 'required|in:facebook,instagram,both',
        'content' => 'required|string|min:10|max:2200',
        'scheduled_at' => 'nullable|date|after:now',
        'status' => 'required|in:draft,scheduled,published,failed',
    ];

    public function render()
    {
        $posts = SocialMediaPost::query()
            ->when($this->search, function($query) {
                $query->where('content', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterPlatform, function($query) {
                $query->where('platform', $this->filterPlatform);
            })
            ->when($this->filterStatus, function($query) {
                $query->where('status', $this->filterStatus);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(15);

        $accounts = SocialMediaAccount::where('is_active', true)->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();

        $stats = [
            'total' => SocialMediaPost::count(),
            'published' => SocialMediaPost::where('status', 'published')->count(),
            'scheduled' => SocialMediaPost::where('status', 'scheduled')->count(),
            'failed' => SocialMediaPost::where('status', 'failed')->count(),
        ];

        return view('livewire.admin.social-media.social-media-manager', [
            'posts' => $posts,
            'accounts' => $accounts,
            'products' => $products,
            'stats' => $stats,
        ])->layout('components.layouts.admin', [
            'title' => 'Gestão de Redes Sociais',
            'pageTitle' => 'Redes Sociais'
        ]);
    }

    public function openModal($postId = null): void
    {
        $this->resetFields();
        $this->resetValidation();

        if ($postId) {
            $this->editMode = true;
            $this->selectedPost = SocialMediaPost::findOrFail($postId);
            $this->loadPostData();
        } else {
            $this->editMode = false;
            $this->selectedPost = null;
        }

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetFields();
        $this->resetValidation();
    }

    public function generateAIContent(): void
    {
        if (empty($this->product_ids)) {
            $this->dispatch('error', 'Selecione pelo menos um produto para gerar conteúdo.');
            return;
        }

        $products = Product::with(['category', 'brand'])->whereIn('id', $this->product_ids)->get();
        
        $prompt = $this->buildAIPrompt($products);
        
        try {
            $response = OpenAI::completions()->create([
                'model' => 'gpt-3.5-turbo-instruct',
                'prompt' => $prompt,
                'max_tokens' => 500,
                'temperature' => 0.7,
            ]);

            $this->content = $response['choices'][0]['text'] ?? '';
            $this->dispatch('success', 'Conteúdo gerado com sucesso!');
        } catch (\Exception $e) {
            $this->dispatch('error', 'Erro ao gerar conteúdo: ' . $e->getMessage());
        }
    }

    public function savePost(): void
    {
        $this->validate();

        $data = [
            'platform' => $this->platform,
            'content' => $this->content,
            'images' => $this->images,
            'scheduled_at' => $this->scheduled_at,
            'status' => $this->status,
            'product_ids' => $this->product_ids,
            'user_id' => auth()->id(),
        ];

        if ($this->editMode) {
            $this->selectedPost->update($data);
            $message = 'Post atualizado com sucesso!';
        } else {
            SocialMediaPost::create($data);
            $message = 'Post criado com sucesso!';
        }

        $this->dispatch('success', $message);
        $this->closeModal();
    }

    public function publishNow($postId): void
    {
        $post = SocialMediaPost::findOrFail($postId);
        
        try {
            $this->publishToSocialMedia($post);
            $post->update([
                'status' => 'published',
                'published_at' => now(),
            ]);
            
            $this->dispatch('success', 'Post publicado com sucesso!');
        } catch (\Exception $e) {
            $post->update(['status' => 'failed']);
            $this->dispatch('error', 'Erro ao publicar: ' . $e->getMessage());
        }
    }

    public function duplicatePost($postId): void
    {
        $post = SocialMediaPost::findOrFail($postId);
        
        $newPost = $post->replicate([
            'published_at',
            'external_id',
        ]);
        
        $newPost->status = 'draft';
        $newPost->content .= ' (Cópia)';
        $newPost->save();
        
        $this->dispatch('success', 'Post duplicado com sucesso!');
    }

    public function deletePost($postId): void
    {
        $post = SocialMediaPost::findOrFail($postId);
        $post->delete();
        $this->dispatch('success', 'Post eliminado com sucesso!');
    }

    public function schedulePost($postId, $dateTime): void
    {
        $post = SocialMediaPost::findOrFail($postId);
        $post->update([
            'scheduled_at' => $dateTime,
            'status' => 'scheduled',
        ]);
        
        $this->dispatch('success', 'Post agendado com sucesso!');
    }

    private function buildAIPrompt($products): string
    {
        $productNames = $products->pluck('name')->join(', ');
        $categories = $products->pluck('category.name')->unique()->join(', ');
        
        $tone = match($this->ai_tone) {
            'friendly' => 'amigável e acolhedor',
            'professional' => 'profissional e formal',
            'casual' => 'casual e descontraído',
            'enthusiastic' => 'entusiástico e energético',
            default => 'amigável'
        };
        
        $style = match($this->ai_style) {
            'promotional' => 'promocional com foco em vendas',
            'informative' => 'informativo e educativo',
            'storytelling' => 'narrativo e envolvente',
            'minimalist' => 'minimalista e direto',
            default => 'promocional'
        };

        $platform_limit = $this->platform === 'instagram' ? '150' : '200';

        return "Crie um post para {$this->platform} em português de Angola sobre os seguintes produtos: {$productNames}. 
                Categorias: {categories}.
                Tom: {$tone}
                Estilo: {$style}
                Máximo {$platform_limit} palavras.
                Inclua emojis apropriados e call-to-action.
                Para Instagram, inclua hashtags relevantes.
                Foque na qualidade, preços competitivos e entrega em Angola.";
    }

    private function publishToSocialMedia($post): void
    {
        $accounts = SocialMediaAccount::where('platform', $post->platform)
            ->where('is_active', true)
            ->get();

        foreach ($accounts as $account) {
            $this->publishToAccount($post, $account);
        }
    }

    private function publishToAccount($post, $account): void
    {
        if ($account->platform === 'facebook') {
            $this->publishToFacebook($post, $account);
        } elseif ($account->platform === 'instagram') {
            $this->publishToInstagram($post, $account);
        }
    }

    private function publishToFacebook($post, $account): void
    {
        $url = "https://graph.facebook.com/v18.0/{$account->page_id}/feed";
        
        $data = [
            'message' => $post->content,
            'access_token' => $account->access_token,
        ];

        if (!empty($post->images)) {
            // Handle image upload for Facebook
            $data['link'] = $post->images[0] ?? '';
        }

        $response = Http::post($url, $data);
        
        if (!$response->successful()) {
            throw new \Exception('Erro ao publicar no Facebook: ' . $response->body());
        }
    }

    private function publishToInstagram($post, $account): void
    {
        // Instagram requires image for posts
        if (empty($post->images)) {
            throw new \Exception('Instagram requer pelo menos uma imagem');
        }

        $url = "https://graph.facebook.com/v18.0/{$account->page_id}/media";
        
        $data = [
            'image_url' => $post->images[0],
            'caption' => $post->content,
            'access_token' => $account->access_token,
        ];

        $response = Http::post($url, $data);
        
        if (!$response->successful()) {
            throw new \Exception('Erro ao criar post no Instagram: ' . $response->body());
        }

        $mediaId = $response->json()['id'];
        
        // Publish the media
        $publishUrl = "https://graph.facebook.com/v18.0/{$account->page_id}/media_publish";
        $publishResponse = Http::post($publishUrl, [
            'creation_id' => $mediaId,
            'access_token' => $account->access_token,
        ]);
        
        if (!$publishResponse->successful()) {
            throw new \Exception('Erro ao publicar no Instagram: ' . $publishResponse->body());
        }
    }

    private function resetFields(): void
    {
        $this->platform = 'facebook';
        $this->content = '';
        $this->images = [];
        $this->scheduled_at = '';
        $this->status = 'draft';
        $this->product_ids = [];
    }

    private function loadPostData(): void
    {
        $this->platform = $this->selectedPost->platform;
        $this->content = $this->selectedPost->content;
        $this->images = $this->selectedPost->images ?? [];
        $this->scheduled_at = $this->selectedPost->scheduled_at?->format('Y-m-d\TH:i');
        $this->status = $this->selectedPost->status;
        $this->product_ids = $this->selectedPost->product_ids ?? [];
    }
}
