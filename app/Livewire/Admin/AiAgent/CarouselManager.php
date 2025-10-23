<?php

namespace App\Livewire\Admin\AiAgent;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AiAutoPost;
use App\Models\Product;
use Illuminate\Support\Facades\Artisan;

class CarouselManager extends Component
{
    use WithPagination;

    public $platform = 'facebook';
    public $productsCount = 10;
    public $showCreateModal = false;
    public $showPreviewModal = false;
    public $showPublishModal = false;
    public $selectedCarousel = [];
    public $selectedProducts = [];
    public $postToPublish = null;

    protected $queryString = ['platform'];

    public function mount()
    {
        $this->productsCount = 10;
    }

    public function createCarousel()
    {
        $this->validate([
            'platform' => 'required|in:facebook,instagram',
            'productsCount' => 'required|integer|min:3|max:10',
        ]);

        try {
            Artisan::call('ai:auto-create-carousel', [
                '--platform' => $this->platform,
                '--products' => $this->productsCount,
            ]);

            session()->flash('success', '🎉 Carrossel criado com sucesso!');
            $this->showCreateModal = false;
            $this->resetPage();
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao criar carrossel: ' . $e->getMessage());
        }
    }

    public function deletePost($postId)
    {
        $post = AiAutoPost::find($postId);
        
        if ($post && $post->status === 'scheduled') {
            $post->delete();
            session()->flash('success', 'Carrossel cancelado com sucesso!');
        }
    }

    public function previewCarousel($postId)
    {
        $post = AiAutoPost::with('product')->find($postId);
        
        if (!$post) {
            session()->flash('error', 'Carrossel não encontrado!');
            return;
        }

        $this->selectedCarousel = [
            'id' => $post->id,
            'platform' => $post->platform,
            'products_count' => count($post->product_ids ?? []),
            'content' => $post->content,
            'media_urls' => $post->media_urls ?? [],
            'scheduled_for' => $post->scheduled_for->format('d/m/Y H:i'),
            'status' => $post->status,
        ];

        $this->showPreviewModal = true;
    }

    public function showPublishConfirmation($postId)
    {
        $post = AiAutoPost::find($postId);
        
        if (!$post) {
            session()->flash('error', 'Carrossel não encontrado!');
            return;
        }

        $this->postToPublish = [
            'id' => $post->id,
            'platform' => $post->platform,
            'products_count' => count($post->product_ids ?? []),
            'content' => $post->content,
            'media_urls' => $post->media_urls ?? [],
            'scheduled_for' => $post->scheduled_for->format('d/m/Y H:i'),
        ];

        $this->showPublishModal = true;
    }

    public function confirmPublish()
    {
        if (!$this->postToPublish) {
            return;
        }

        $post = AiAutoPost::find($this->postToPublish['id']);
        
        if (!$post) {
            session()->flash('error', 'Carrossel não encontrado!');
            $this->showPublishModal = false;
            return;
        }

        try {
            // Publicar imediatamente usando o serviço
            $socialMediaService = app(\App\Services\SocialMediaAgentService::class);
            
            // Atualizar status para scheduled e hora para agora
            $post->update([
                'status' => 'scheduled',
                'scheduled_for' => now()->subMinute(),
            ]);
            
            // Publicar posts pendentes (irá pegar este post)
            $published = $socialMediaService->publishPendingPosts();
            
            if ($published > 0) {
                session()->flash('success', '🎉 Carrossel publicado com sucesso!');
            } else {
                session()->flash('error', '❌ Erro ao publicar. Verifique os logs ou tente novamente.');
            }
            
            $this->showPublishModal = false;
            $this->postToPublish = null;
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao publicar: ' . $e->getMessage());
            $this->showPublishModal = false;
        }
    }

    public function render()
    {
        $carousels = AiAutoPost::with('product')
            ->where('post_type', 'carousel')
            ->where('platform', $this->platform)
            ->latest('created_at')
            ->paginate(10);

        $availableProducts = Product::where('is_active', true)
            ->whereNotNull('featured_image')
            ->where('stock_quantity', '>', 0)
            ->count();

        return view('livewire.admin.ai-agent.carousel-manager', [
            'carousels' => $carousels,
            'availableProducts' => $availableProducts,
        ])->layout('components.layouts.admin');
    }
}
