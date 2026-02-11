<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Auction;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('Leilões - SuperLoja')]
class AuctionsPage extends Component
{
    use WithPagination;

    public function render()
    {
        $auctions = Auction::with(['product'])
            ->where('status', 'active')
            ->where('end_time', '>', now())
            ->paginate(12);
        
        return view('livewire.pages.auctions', compact('auctions'))
            ->layout('layouts.app');
    }
}
