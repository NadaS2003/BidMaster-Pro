<?php
namespace App\Livewire;
use App\Models\Bid;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AuctionStatus extends Component
{
    public $auction;
    public $amount;
    protected $listeners = ['refresh' => '$refresh'];

    public function mount($auction)
    {
        $this->auction = $auction;
    }
    public function placeBid()
    {
    //    dd('وصلت للدالة');
        try {
            $this->validate([
                'amount' => 'required|numeric|gt:' . ($this->auction->bids()->max('amount') ?? $this->auction->starting_price),
            ]);

            \App\Models\Bid::create([
                'auction_id' => $this->auction->id,
                'user_id' => \Illuminate\Support\Facades\Auth::id(),
                'amount' => $this->amount,
            ]);

            $this->amount = '';
            $this->dispatch('refresh');

        } catch (\Exception $e) {
            // هذا السطر سيكتب الخطأ في الـ Console إذا كان هناك مشكلة في الحفظ
            dd($e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.auction-status');
    }
};
?>
