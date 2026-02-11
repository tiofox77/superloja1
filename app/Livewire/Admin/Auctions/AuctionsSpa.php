<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Auctions;

use App\Models\Auction;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

#[Layout('components.admin.layouts.app')]
#[Title('Leilões')]
class AuctionsSpa extends Component
{
    use WithPagination;
    
    #[Url]
    public string $search = '';
    
    #[Url]
    public string $status = '';
    
    public int $perPage = 12;
    
    // Modal
    public bool $showModal = false;
    public ?int $editingId = null;
    public ?int $product_id = null;
    public float $starting_price = 0;
    public float $reserve_price = 0;
    public float $bid_increment = 100;
    public string $starts_at = '';
    public string $ends_at = '';
    public string $auctionStatus = 'pending';
    
    protected function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'starting_price' => 'required|numeric|min:0',
            'reserve_price' => 'nullable|numeric|min:0',
            'bid_increment' => 'required|numeric|min:1',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'auctionStatus' => 'required|in:pending,active,ended,cancelled',
        ];
    }
    
    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    
    public function openCreateModal(): void
    {
        $this->reset(['editingId', 'product_id', 'starting_price', 'reserve_price', 'bid_increment', 'starts_at', 'ends_at', 'auctionStatus']);
        $this->auctionStatus = 'pending';
        $this->bid_increment = 100;
        $this->starts_at = now()->format('Y-m-d\TH:i');
        $this->ends_at = now()->addDays(7)->format('Y-m-d\TH:i');
        $this->showModal = true;
    }
    
    public function editAuction(int $id): void
    {
        $auction = Auction::find($id);
        if ($auction) {
            $this->editingId = $auction->id;
            $this->product_id = $auction->product_id;
            $this->starting_price = $auction->starting_price;
            $this->reserve_price = $auction->reserve_price ?? 0;
            $this->bid_increment = $auction->bid_increment;
            $this->starts_at = $auction->starts_at?->format('Y-m-d\TH:i') ?? '';
            $this->ends_at = $auction->ends_at?->format('Y-m-d\TH:i') ?? '';
            $this->auctionStatus = $auction->status;
            $this->showModal = true;
        }
    }
    
    public function saveAuction(): void
    {
        $this->validate();
        
        $data = [
            'product_id' => $this->product_id,
            'starting_price' => $this->starting_price,
            'reserve_price' => $this->reserve_price ?: null,
            'bid_increment' => $this->bid_increment,
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
            'status' => $this->auctionStatus,
        ];
        
        if ($this->editingId) {
            Auction::find($this->editingId)->update($data);
            $message = 'Leilão atualizado!';
        } else {
            $data['current_price'] = $this->starting_price;
            Auction::create($data);
            $message = 'Leilão criado!';
        }
        
        $this->showModal = false;
        $this->dispatch('toast', ['type' => 'success', 'message' => $message]);
    }
    
    public function deleteAuction(int $id): void
    {
        Auction::find($id)?->delete();
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Leilão excluído!']);
    }
    
    public function render()
    {
        $auctions = Auction::query()
            ->with(['product', 'bids'])
            ->withCount('bids')
            ->when($this->search, fn($q) => $q->whereHas('product', fn($p) => $p->where('name', 'like', "%{$this->search}%")))
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
        
        $products = Product::where('is_active', true)->orderBy('name')->get();
        
        $stats = [
            'total' => Auction::count(),
            'active' => Auction::where('status', 'active')->count(),
            'pending' => Auction::where('status', 'pending')->count(),
            'ended' => Auction::where('status', 'ended')->count(),
        ];
        
        return view('livewire.admin.auctions.index-spa', [
            'auctions' => $auctions,
            'products' => $products,
            'stats' => $stats,
        ]);
    }
}
