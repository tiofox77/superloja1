<?php

declare(strict_types=1);

namespace App\Livewire\Admin\AiAgent;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AiAutoPost;
use App\Models\Product;
use App\Services\SocialMediaAgentService;
use Carbon\Carbon;

class PostScheduler extends Component
{
    use WithPagination;

    public $showModal = false;
    public $showDeleteModal = false;
    public $showErrorModal = false;
    public $showPreviewModal = false;
    public $postToDelete;
    public $selectedError;
    public $previewPost;
    public $generatedPreview;
    public $platform = 'facebook';
    public $selectedProductId;
    public $scheduledFor;
    public $customContent;

    public function mount()
    {
        $this->scheduledFor = now()->addHours(2)->format('Y-m-d\TH:i');
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['selectedProductId', 'customContent', 'scheduledFor', 'platform', 'generatedPreview']);
        $this->scheduledFor = now()->addHours(2)->format('Y-m-d\TH:i');
    }

    public function updatedSelectedProductId($productId)
    {
        if (!$productId) {
            $this->generatedPreview = null;
            return;
        }

        $product = Product::with('category')->find($productId);
        
        if (!$product) {
            $this->generatedPreview = null;
            return;
        }

        // Gerar preview automaticamente usando o serviço
        $socialMediaService = app(SocialMediaAgentService::class);
        $postData = $socialMediaService->generateProductPostContent($product, $this->platform);
        
        $this->generatedPreview = [
            'product' => $product,
            'content' => $postData['message'], // Corrigido: 'message' não 'content'
            'hashtags' => $postData['hashtags'],
            'media_urls' => $postData['media_urls'],
        ];

        // Se não tiver conteúdo customizado, usar o gerado
        if (empty($this->customContent)) {
            $this->customContent = $postData['message']; // Corrigido: 'message' não 'content'
        }
    }

    public function updatedPlatform()
    {
        // Regenerar preview quando mudar plataforma
        if ($this->selectedProductId) {
            $this->updatedSelectedProductId($this->selectedProductId);
        }
    }

    public function schedulePost()
    {
        $this->validate([
            'platform' => 'required|in:facebook,instagram',
            'selectedProductId' => 'required|exists:products,id',
            'scheduledFor' => 'required|date|after:now',
        ]);

        $product = Product::find($this->selectedProductId);
        $socialMediaAgent = app(SocialMediaAgentService::class);

        $post = $socialMediaAgent->scheduleAutoPost(
            $product,
            $this->platform,
            Carbon::parse($this->scheduledFor)
        );

        if ($this->customContent) {
            $post->update(['content' => $this->customContent]);
        }

        session()->flash('message', 'Post agendado com sucesso!');
        $this->closeModal();
    }

    public function publishNow($postId)
    {
        $post = AiAutoPost::find($postId);
        
        if (!$post) {
            return;
        }

        $socialMediaAgent = app(SocialMediaAgentService::class);
        
        // Publicar imediatamente
        $post->update(['scheduled_for' => now()]);
        $socialMediaAgent->publishPendingPosts();

        session()->flash('message', 'Publicando post...');
    }

    public function confirmDelete($postId)
    {
        $this->postToDelete = $postId;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->postToDelete = null;
    }

    public function deletePost()
    {
        if ($this->postToDelete) {
            AiAutoPost::destroy($this->postToDelete);
            session()->flash('message', 'Post removido com sucesso!');
            $this->cancelDelete();
        }
    }

    public function showErrorDetails($postId)
    {
        $post = AiAutoPost::with('product')->find($postId);
        
        if ($post) {
            $this->selectedError = [
                'id' => $post->id,
                'platform' => $post->platform,
                'error' => $post->error_message ?? 'Erro desconhecido',
                'scheduled_for' => $post->scheduled_for?->format('d/m/Y H:i') ?? 'N/A',
                'created_at' => $post->created_at->format('d/m/Y H:i'),
                'content' => $post->content,
                'media_urls' => $post->media_urls,
                'product_name' => $post->product?->name ?? 'N/A',
            ];
            $this->showErrorModal = true;
        }
    }

    public function closeErrorModal()
    {
        $this->showErrorModal = false;
        $this->selectedError = null;
    }

    public function retryPost($postId)
    {
        $post = AiAutoPost::find($postId);
        
        if ($post) {
            // Resetar status para agendado e agendar para agora
            $post->update([
                'status' => 'scheduled',
                'scheduled_for' => now(),
                'error_message' => null,
            ]);

            // Tentar publicar imediatamente
            $this->publishNow($postId);
            
            $this->closeErrorModal();
            session()->flash('message', 'Tentando publicar novamente...');
        }
    }

    public function showPreview($postId)
    {
        $post = AiAutoPost::with('product')->find($postId);
        
        if ($post) {
            $this->previewPost = [
                'id' => $post->id,
                'product_name' => $post->product?->name ?? 'Produto',
                'platform' => $post->platform,
                'content' => $post->content,
                'media_urls' => $post->media_urls ?? [],
                'hashtags' => $post->hashtags ?? [],
                'scheduled_for' => $post->scheduled_for?->format('d/m/Y H:i') ?? 'Agora',
                'status' => $post->status,
            ];
            $this->showPreviewModal = true;
        }
    }

    public function closePreview()
    {
        $this->showPreviewModal = false;
        $this->previewPost = null;
    }

    public function render()
    {
        $posts = AiAutoPost::with('product')
            ->orderByDesc('created_at')
            ->paginate(15);

        $products = Product::active()
            ->with('category')
            ->orderBy('name')
            ->get();

        return view('livewire.admin.ai-agent.post-scheduler', [
            'posts' => $posts,
            'products' => $products,
        ])->layout('components.layouts.admin', [
            'title' => 'Posts Automáticos',
            'pageTitle' => 'AI Agent - Posts'
        ]);
    }
}
