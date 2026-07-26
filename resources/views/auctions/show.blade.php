<x-layout>
    <x-slot:title>{{ $auction->title }} | BidMaster Pro</x-slot:title>

    <div class="px-lg py-xl max-w-container-max mx-auto">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-xs text-on-surface-variant hover:text-primary mb-lg font-label-md text-label-md transition-colors">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Back to Live Auctions
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-xl">
            <div class="lg:col-span-2 space-y-lg">
                <div class="glass-card rounded-xl overflow-hidden relative h-96">
                    @if($auction->image_path)
                        <img src="{{ asset('storage/' . $auction->image_path) }}" alt="{{ $auction->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-surface-container-highest flex items-center justify-center text-on-surface-variant font-label-md">
                            No Image Available
                        </div>
                    @endif
                        <div
                            @class([
                                'absolute top-md left-md backdrop-blur-md px-sm py-1 rounded-full flex items-center gap-1 border',
                                'bg-green-500/20 border-green-500/40' => $auction->status->value == 'active',
                                'bg-yellow-500/20 border-yellow-500/40' => $auction->status->value == 'upcoming',
                                'bg-red-500/20 border-red-500/40' => $auction->status->value == 'ended',
                            ])>
                            <span @class([
                                    'w-1.5 h-1.5 rounded-full',
                                    'bg-green-400 animate-pulse' => $auction->status->value == 'active',
                                    'bg-yellow-400' => $auction->status->value == 'upcoming',
                                    'bg-red-400' => $auction->status->value == 'ended',
                                ])></span>

                            <span @class([
                                    'font-label-sm text-label-sm uppercase tracking-wider font-bold',
                                    'text-green-400' => $auction->status->value == 'active',
                                    'text-yellow-400' => $auction->status->value == 'upcoming',
                                    'text-red-400' => $auction->status->value == 'ended',
                                ])>
                                    {{ $auction->status }}
                                </span>
                        </div>
                </div>

                <div class="glass-card p-xl rounded-xl space-y-md">
                    <h1 class="font-headline-lg text-headline-lg text-on-surface font-bold">{{ $auction->title }}</h1>
                    <div class="flex items-center gap-md text-body-sm text-on-surface-variant border-b border-outline-variant pb-md">
                        <span>Seller: <strong class="text-primary">{{ $auction->seller->name ?? 'Verified Seller' }}</strong></span>
                        <span>•</span>
                        <span>Listed: {{ $auction->created_at ? $auction->created_at->diffForHumans() : 'Recently' }}</span>
                    </div>
                    <div>
                        <h3 class="font-headline-md text-headline-md text-on-surface mb-xs font-semibold">Description</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed whitespace-pre-line">
                            {{ $auction->description }}
                        </p>
                    </div>
                    @if($auction->ai_evaluation)
                        <div class="bg-surface-container-high border border-primary/30 p-md rounded-xl text-body-sm text-on-surface">
                            <div class="flex items-center gap-xs text-primary font-bold mb-xs">
                                <span class="material-symbols-outlined text-[20px]">smart_toy</span>
                                AI Authenticity & Condition Assessment
                            </div>
                            <p class="text-on-surface-variant">{!! Illuminate\Support\Str::markdown($auction->ai_evaluation) !!}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="space-y-lg">
                <div class="glass-card p-lg rounded-xl space-y-4">
                    <h2 class="text-lg font-bold text-on-surface">Auction Status</h2>

                    <div class="flex justify-between items-center">
                        <span class="text-on-surface-variant">Status</span>

                        <span id="auction-status" @class([
                            'px-3 py-1 rounded-full text-xs font-bold uppercase border',
                            'bg-green-500/20 text-green-400 border-green-500/40' => $auction->status->value == 'active',
                            'bg-yellow-500/20 text-yellow-400 border-yellow-500/40' => $auction->status->value == 'upcoming',
                            'bg-red-500/20 text-red-400 border-red-500/40' => $auction->status->value == 'ended',
                        ])>
                            {{ $auction->status}}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">
                            Ends In
                        </span>

                        <span
                            id="countdown"
                            class="font-bold text-secondary"
                            data-end="{{ $auction->end_time }}"
                        >
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Current Price</span>

                        <span id="current-price" class="font-bold text-primary">
                            ${{ number_format($auction->current_price, 2) }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Total Bids</span>
                        <span id="bids-count">
                            {{ $auction->bids->count() }}
                        </span>
                    </div>
                    <div id="auction-result">

                    @if($auction->status === \App\Enums\AuctionStatus::ENDED)

                        <hr class="border-outline-variant">

                        <h3 class="text-base font-semibold text-green-400 flex items-center gap-2">
                            🏆 Auction Result
                        </h3>

                        @if($auction->winner)
                            <div class="flex justify-between">
                                <span class="text-on-surface-variant">Winner</span>
                                <span class="font-semibold text-on-surface">
                                    {{ $auction->winner->name }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-on-surface-variant">Winning Bid</span>
                                <span class="font-bold text-primary">
                                    ${{ number_format($auction->current_price, 2) }}
                                </span>
                            </div>
                        @else
                            <div class="rounded-lg bg-yellow-500/10 border border-yellow-500/20 p-3">
                                <p class="text-yellow-400 text-sm">
                                    No bids were placed on this auction.
                                </p>
                            </div>
                        @endif
                    @endif
                    </div>
                </div>
                @auth


                        @if($auction->status === \App\Enums\AuctionStatus::ACTIVE
                            && auth()->id() !== $auction->user_id)


                            <hr class="border-outline-variant">


                            <form action="{{ route('bids.store', $auction) }}" method="POST" class="space-y-3">

                                @csrf


                                <label class="block text-sm text-on-surface-variant">
                                    Your Bid Amount
                                </label>


                                <input
                                    type="number"
                                    name="amount"
                                    step="0.01"
                                    min="{{ $auction->current_price + 1 }}"
                                    placeholder="Enter your bid"
                                    class="w-full bg-surface-container border border-outline-variant rounded-lg px-3 py-2 text-on-surface focus:border-primary focus:ring-primary"
                                    required
                                >


                                @error('amount')
                                <p class="text-red-400 text-sm">
                                    {{ $message }}
                                </p>
                                @enderror



                                <button
                                    type="submit"
                                    class="w-full bg-primary text-on-primary py-2 rounded-lg font-bold hover:brightness-110 transition">

                                    Place Bid

                                </button>


                            </form>


                        @endif


                @if (auth()->id() === $auction->user_id)

                        <div class="flex items-center gap-xs bg-surface-container p-sm rounded-xl border border-outline-variant justify-end mb-md">
                            <a href="{{ route('auctions.edit', $auction->id) }}" class="bg-primary/20 text-primary border border-primary/40 hover:bg-primary hover:text-on-primary px-md py-xs rounded-lg text-xs font-bold transition-all flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">edit</span> Edit Auction
                            </a>
                            <form action="{{ route('auctions.destroy', $auction->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-500/20 text-red-400 border border-red-500/40 hover:bg-red-500 hover:text-white px-md py-xs rounded-lg text-xs font-bold transition-all flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px]">delete</span> Delete
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            if (!window.Echo) {
                console.error('Echo is not loaded');
                return;
            }

            console.log('Echo ready');

            window.Echo.channel('auction.{{ $auction->id }}')
                .listen('.BidPlaced', (event) => {

                    console.log('EVENT RECEIVED', event);

                    const price = document.getElementById('current-price');

                    price.classList.add('scale-125','text-secondary');

                    setTimeout(()=>{
                        price.classList.remove('scale-125','text-secondary');
                    },500);

                    document.getElementById('bids-count').innerText =
                        event.bids_count;

                    document.getElementById('current-price').innerText =
                        '$' + event.amount;
                })
                .listen('.AuctionEnded', (event)=>{

                    console.log('AUCTION ENDED EVENT', event);

                    const status = document.getElementById('auction-status');

                    console.log('STATUS ELEMENT:', status);

                    if(status){

                        status.textContent = 'ENDED';

                        status.className =
                            'px-3 py-1 rounded-full text-xs font-bold uppercase border bg-red-500/20 text-red-400 border-red-500/40';

                    }

                    if(event.winner){

                        document.getElementById('auction-result').innerHTML = `

                                <hr class="border-outline-variant">

                                <h3 class="text-base font-semibold text-green-400">
                                🏆 Auction Result
                                </h3>

                                <div class="flex justify-between">
                                <span>Winner</span>
                                <span>${event.winner}</span>
                                </div>

                                <div class="flex justify-between">
                                <span>Winning Bid</span>
                                <span>$${event.price}</span>
                                </div>

                                `;

                    }

                });


        });
    </script>
    <script>

        const countdown = document.getElementById('countdown');

        const endTime = new Date(
            countdown.dataset.end
        ).getTime();


        const timer = setInterval(()=>{

            const now = new Date().getTime();

            const distance = endTime - now;


            if(distance <= 0){

                clearInterval(timer);

                countdown.innerHTML = "Auction Ended";

                return;
            }


            const hours = Math.floor(
                distance / (1000 * 60 * 60)
            );


            const minutes = Math.floor(
                (distance % (1000*60*60))
                /
                (1000*60)
            );


            const seconds = Math.floor(
                (distance % (1000*60))
                /
                1000
            );


            countdown.innerHTML =
                String(hours).padStart(2,'0')
                + ":" +
                String(minutes).padStart(2,'0')
                + ":" +
                String(seconds).padStart(2,'0');


        },1000);


    </script>
</x-layout>
