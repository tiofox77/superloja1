<?php

namespace App\Livewire;

use App\Models\Auction;
use App\Models\AuctionBid;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AuctionBidding extends Component
{
    public $auction;
    public $bidAmount;
    public $showBidModal = false;
    public $showBuyNowModal = false;
    public $minBidAmount;
    public $enablePolling = true; // Polling para atualizações automáticas

    public function mount(Auction $auction)
    {
        $this->auction = $auction;
        $this->calculateMinBid();
    }

    protected function calculateMinBid()
    {
        $this->minBidAmount = $this->auction->current_bid + $this->auction->bid_increment;
        // Não definir valor padrão para permitir sugestões
        if (!$this->bidAmount || $this->bidAmount < $this->minBidAmount) {
            $this->bidAmount = $this->minBidAmount;
        }
    }

    public function refreshAuction()
    {
        // Sempre atualizar este leilão do banco
        $this->auction = $this->auction->fresh();
        $this->calculateMinBid();
    }

    #[\Livewire\Attributes\On('auction-updated')]
    public function onAuctionUpdated($auctionId = null)
    {
        // Atualizar se for o mesmo leilão
        if (!$auctionId || $auctionId == $this->auction->id) {
            $this->refreshAuction();
        }
    }

    public function openBidModal()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->calculateMinBid();
        $this->showBidModal = true;
    }

    public function closeBidModal()
    {
        $this->showBidModal = false;
        $this->reset('bidAmount');
    }

    public function openBuyNowModal()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->showBuyNowModal = true;
    }

    public function closeBuyNowModal()
    {
        $this->showBuyNowModal = false;
    }

    public function placeBid()
    {
        // Validações customizadas
        $this->validate([
            'bidAmount' => ['required', 'numeric', 'min:' . $this->minBidAmount]
        ], [
            'bidAmount.required' => 'Por favor, insira o valor do seu lance',
            'bidAmount.numeric' => 'O valor deve ser um número válido',
            'bidAmount.min' => 'Seu lance deve ser de pelo menos ' . number_format((float)$this->minBidAmount, 0, ',', '.') . ' Kz'
        ]);

        try {
            // Verificar se o leilão ainda está ativo
            if (!$this->auction->isActive()) {
                $this->dispatch('showAlert', [
                    'type' => 'error',
                    'message' => 'Este leilão já não está ativo.'
                ]);
                return;
            }

            // Criar o lance
            AuctionBid::create([
                'auction_id' => $this->auction->id,
                'user_id' => Auth::id(),
                'bid_amount' => $this->bidAmount,
                'ip_address' => request()->ip(),
            ]);

            // Atualizar o leilão
            $this->auction->update([
                'current_bid' => $this->bidAmount,
                'bid_count' => $this->auction->bid_count + 1
            ]);

            // Auto-extend se configurado
            if ($this->auction->auto_extend && $this->auction->end_time->diffInMinutes(now()) <= $this->auction->extend_minutes) {
                $this->auction->update([
                    'end_time' => $this->auction->end_time->addMinutes($this->auction->extend_minutes)
                ]);
            }

            // Recarregar dados do leilão do banco
            $this->auction = $this->auction->fresh();
            
            // Recalcular valores mínimos
            $this->calculateMinBid();

            $this->dispatch('showAlert', [
                'type' => 'success', 
                'message' => 'Lance realizado com sucesso!'
            ]);

            $this->closeBidModal();

            // Emit events para outros componentes
            $this->dispatch('bidPlaced', ['auctionId' => $this->auction->id, 'newBid' => $this->bidAmount]);
            $this->dispatch('auction-updated', $this->auction->id);

        } catch (\Exception $e) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Erro ao fazer lance: ' . $e->getMessage()
            ]);
        }
    }

    public function buyNow()
    {
        try {
            // Verificar se o leilão ainda está ativo
            if (!$this->auction->isActive()) {
                $this->dispatch('showAlert', [
                    'type' => 'error',
                    'message' => 'Este leilão já não está ativo.'
                ]);
                return;
            }

            // Verificar se tem buy_now_price
            if (!$this->auction->buy_now_price) {
                $this->dispatch('showAlert', [
                    'type' => 'error',
                    'message' => 'Este leilão não permite compra imediata.'
                ]);
                return;
            }

            // Finalizar leilão com venda direta
            $this->auction->update([
                'status' => 'sold',
                'winner_id' => Auth::id(),
                'winning_bid' => $this->auction->buy_now_price,
                'current_bid' => $this->auction->buy_now_price,
                'won_at' => now(),
                'end_time' => now()
            ]);

            // Criar registro do lance vencedor
            AuctionBid::create([
                'auction_id' => $this->auction->id,
                'user_id' => Auth::id(),
                'bid_amount' => $this->auction->buy_now_price,
                'ip_address' => request()->ip(),
                'is_buy_now' => true
            ]);

            // Recarregar dados do leilão
            $this->auction->refresh();

            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => 'Parabéns! Produto comprado com sucesso!'
            ]);

            $this->closeBuyNowModal();

            // Emit events para outros componentes
            $this->dispatch('purchaseCompleted', ['auctionId' => $this->auction->id]);
            $this->dispatch('auction-updated', $this->auction->id);

        } catch (\Exception $e) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Erro ao comprar: ' . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.auction-bidding');
    }
}
