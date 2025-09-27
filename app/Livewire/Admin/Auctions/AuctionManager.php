<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Auctions;

use App\Models\Auction;
use App\Models\Product;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AuctionManager extends Component
{
    use WithPagination;

    public $showModal = false;
    public $editMode = false;
    public $selectedAuction = null;

    // Form fields
    public $product_id = '';
    public $title = '';
    public $description = '';
    public $starting_price = '';
    public $current_price = '';
    public $reserve_price = '';
    public $buy_now_price = '';
    public $start_time = '';
    public $end_time = '';
    public $status = 'draft';
    public $featured = false;

    // Filters
    public $search = '';
    public $filterStatus = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    protected $rules = [
        'product_id' => 'required|exists:products,id',
        'title' => 'required|string|min:3|max:255',
        'description' => 'required|string|min:10',
        'starting_price' => 'required|numeric|min:0.01',
        'reserve_price' => 'nullable|numeric|min:0.01',
        'buy_now_price' => 'nullable|numeric|min:0.01',
        'start_time' => 'required|date|after:now',
        'end_time' => 'required|date|after:start_time',
        'status' => 'required|in:draft,active,ended,cancelled',
        'featured' => 'boolean',
    ];

    public function render()
    {
        $auctions = Auction::query()
            ->with(['product', 'winner'])
            ->when($this->search, function($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhereHas('product', function($q) {
                          $q->where('name', 'like', '%' . $this->search . '%');
                      });
            })
            ->when($this->filterStatus, function($query) {
                $query->where('status', $this->filterStatus);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(15);

        $products = Product::where('is_active', true)->orderBy('name')->get();

        $stats = [
            'total' => Auction::count(),
            'active' => Auction::where('status', 'active')->count(),
            'ended' => Auction::where('status', 'ended')->count(),
            'draft' => Auction::where('status', 'draft')->count(),
        ];

        return view('livewire.admin.auctions.auction-manager', [
            'auctions' => $auctions,
            'products' => $products,
            'stats' => $stats,
        ])->layout('components.layouts.admin', [
            'title' => 'Gerir Leilões',
            'pageTitle' => 'Leilões'
        ]);
    }

    public function openModal($auctionId = null): void
    {
        $this->resetFields();
        $this->resetValidation();

        if ($auctionId) {
            $this->editMode = true;
            $this->selectedAuction = Auction::findOrFail($auctionId);
            $this->loadAuctionData();
        } else {
            $this->editMode = false;
            $this->selectedAuction = null;
        }

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetFields();
        $this->resetValidation();
    }

    public function saveAuction(): void
    {
        $this->validate();

        $data = [
            'product_id' => $this->product_id,
            'seller_id' => auth()->id(), // Usuário logado como seller
            'title' => $this->title,
            'description' => $this->description,
            'starting_price' => $this->starting_price,
            'current_bid' => $this->starting_price,
            'reserve_price' => $this->reserve_price,
            'buy_now_price' => $this->buy_now_price,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'status' => $this->status,
        ];

        if ($this->editMode) {
            $this->selectedAuction->update($data);
            $message = 'Leilão atualizado com sucesso!';
        } else {
            Auction::create($data);
            $message = 'Leilão criado com sucesso!';
        }

        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => $message
        ]);
        $this->closeModal();
    }

    public function deleteAuction($auctionId): void
    {
        $auction = Auction::findOrFail($auctionId);
        
        if ($auction->status === 'active') {
            $this->dispatch('showAlert', [
            'type' => 'error',
            'message' => 'Não é possível eliminar um leilão ativo!'
        ]);
            return;
        }

        $auction->delete();
        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => 'Leilão eliminado com sucesso!'
        ]);
    }

    public function toggleStatus($auctionId): void
    {
        $auction = Auction::findOrFail($auctionId);
        
        if ($auction->status === 'draft') {
            $auction->update(['status' => 'active']);
            $message = 'Leilão ativado!';
        } else {
            $auction->update(['status' => 'cancelled']);
            $message = 'Leilão cancelado!';
        }

        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => $message
        ]);
    }

    public function toggleFeatured($auctionId): void
    {
        $auction = Auction::findOrFail($auctionId);
        $auction->update(['featured' => !$auction->featured]);
        
        $message = $auction->featured ? 'Leilão destacado!' : 'Destaque removido!';
        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => $message
        ]);
    }

    private function resetFields(): void
    {
        $this->product_id = '';
        $this->title = '';
        $this->description = '';
        $this->starting_price = '';
        $this->reserve_price = '';
        $this->buy_now_price = '';
        $this->start_time = '';
        $this->end_time = '';
        $this->status = 'draft';
        $this->featured = false;
    }

    private function loadAuctionData(): void
    {
        $this->product_id = $this->selectedAuction->product_id;
        $this->title = $this->selectedAuction->title;
        $this->description = $this->selectedAuction->description;
        $this->starting_price = $this->selectedAuction->starting_price;
        $this->reserve_price = $this->selectedAuction->reserve_price;
        $this->buy_now_price = $this->selectedAuction->buy_now_price;
        $this->start_time = $this->selectedAuction->start_time->format('Y-m-d\TH:i');
        $this->end_time = $this->selectedAuction->end_time->format('Y-m-d\TH:i');
        $this->status = $this->selectedAuction->status;
        $this->featured = $this->selectedAuction->featured;
    }
}
