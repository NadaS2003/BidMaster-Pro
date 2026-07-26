<x-layout>
    <x-slot:title>Active Bids - BidMaster Pro</x-slot:title>

    <div class="space-y-lg">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-md">
            <div>
                <h1 class="font-display-lg text-2xl font-bold text-on-surface">Active Bids</h1>
                <p class="font-body-sm text-on-surface-variant">Track all auctions you've participated in and monitor your bidding status.</p>
            </div>
        </div>

        @if ($auctions->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-lg">
                @foreach ($auctions as $auction)
                    @php
                        $currentPrice = $auction->current_highest_bid ?? $auction->starting_price;
                        $isWinning = $auction->my_highest_bid >= $currentPrice;
                        $isLive = now()->lessThan($auction->end_time);
                    @endphp

                    <div class="bg-surface-container rounded-xl border border-outline-variant overflow-hidden flex flex-col justify-between hover:border-primary/50 transition-all duration-200">

                        <div class="relative h-48 bg-surface-container-highest flex items-center justify-center overflow-hidden">
                            @if ($auction->image_path)
                                <img src="{{ asset('storage/' . $auction->image_path) }}" alt="{{ $auction->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="text-center p-md text-on-surface-variant">
                                    <span class="material-symbols-outlined text-4xl mb-1">image_not_supported</span>
                                    <p class="text-xs">No Image Available</p>
                                </div>
                            @endif

                            <div class="absolute top-3 left-3">
                                @if ($isLive)
                                    @if ($isWinning)
                                        <span class="bg-green-500/20 text-green-400 border border-green-500/40 text-xs font-bold px-2.5 py-1 rounded-full flex items-center gap-1 backdrop-blur-md">
                                            <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                                            WINNING
                                        </span>
                                    @else
                                        <span class="bg-red-500/20 text-red-400 border border-red-500/40 text-xs font-bold px-2.5 py-1 rounded-full flex items-center gap-1 backdrop-blur-md">
                                            <span class="w-2 h-2 rounded-full bg-red-400 animate-pulse"></span>
                                            OUTBID
                                        </span>
                                    @endif
                                @else
                                    <span class="bg-surface-container-highest text-on-surface-variant text-xs font-bold px-2.5 py-1 rounded-full border border-outline-variant">
                                        ENDED
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="p-md flex-1 flex flex-col justify-between space-y-md">
                            <div>
                                <h3 class="font-bold text-on-surface text-lg line-clamp-1 mb-1">{{ $auction->title }}</h3>
                                <p class="text-on-surface-variant text-xs line-clamp-2">{{ $auction->description }}</p>
                            </div>

                            <div class="grid grid-cols-2 gap-2 pt-2 border-t border-outline-variant/50 text-xs">
                                <div class="p-2 rounded-lg bg-surface-container-lowest">
                                    <span class="text-on-surface-variant block text-[11px]">Your Last Bid</span>
                                    <span class="font-bold text-on-surface text-sm">${{ number_format($auction->my_highest_bid, 2) }}</span>
                                </div>
                                <div class="p-2 rounded-lg bg-surface-container-lowest">
                                    <span class="text-on-surface-variant block text-[11px]">Current Highest</span>
                                    <span class="font-bold text-primary text-sm">${{ number_format($currentPrice, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="px-md py-sm bg-surface-container-lowest border-t border-outline-variant flex items-center justify-between">
                            <span class="text-[11px] text-on-surface-variant">
                                {{ $isLive ? 'Ends ' . $auction->end_time->diffForHumans() : 'Ended' }}
                            </span>

                            <a href="{{ route('auctions.show', $auction->id) }}"
                               class="text-xs font-bold px-md py-xs rounded-lg transition-all flex items-center gap-0.5 {{ !$isWinning && $isLive ? 'bg-primary text-on-primary hover:brightness-110' : 'text-primary hover:underline' }}">
                                {{ !$isWinning && $isLive ? 'Raise Bid' : 'View Auction' }}
                                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>

            <div class="pt-md">
                {{ $auctions->links() }}
            </div>
        @else
            <div class="bg-surface-container rounded-xl border border-outline-variant p-xl text-center space-y-md my-lg">
                <div class="w-16 h-16 bg-primary/10 text-primary rounded-full flex items-center justify-center mx-auto">
                    <span class="material-symbols-outlined text-3xl">gavel</span>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-on-surface">No Active Bids</h3>
                    <p class="text-on-surface-variant text-sm max-w-sm mx-auto mt-1">You haven't placed bids on any auctions yet. Browse active listings and make your first bid!</p>
                </div>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-xs bg-primary text-on-primary px-lg py-sm rounded-lg font-bold text-sm hover:brightness-110 transition-all">
                    <span class="material-symbols-outlined text-[18px]">search</span>
                    Explore Auctions
                </a>
            </div>
        @endif
    </div>
</x-layout>
