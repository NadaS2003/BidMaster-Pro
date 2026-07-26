<x-layout>
    <x-slot:title>My Auctions - BidMaster Pro</x-slot:title>

    <div class="space-y-lg">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-md">
            <div>
                <h1 class="font-display-lg text-2xl font-bold text-on-surface">My Auctions</h1>
                <p class="font-body-sm text-on-surface-variant">Manage and track all the auctions you have listed.</p>
            </div>
            <a href="{{ route('auctions.create') }}" class="bg-primary text-on-primary px-md py-xs rounded-lg font-label-md font-bold hover:brightness-110 transition-all flex items-center gap-xs w-fit">
                <span class="material-symbols-outlined text-[18px]">add</span>
                Create New Auction
            </a>
        </div>

        @if ($auctions->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-lg">
                @foreach ($auctions as $auction)
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
                                @if (now()->lessThan($auction->end_time))
                                    <span class="bg-primary/20 text-primary border border-primary/40 text-xs font-bold px-2.5 py-1 rounded-full flex items-center gap-1">
                                        <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                                        LIVE
                                    </span>
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
                                <div>
                                    <span class="text-on-surface-variant block">Starting Price</span>
                                    <span class="font-bold text-on-surface">${{ number_format($auction->starting_price, 2) }}</span>
                                </div>
                                <div>
                                    <span class="text-on-surface-variant block">Total Bids</span>
                                    <span class="font-bold text-primary">{{ $auction->bids_count }} Bids</span>
                                </div>
                            </div>
                        </div>

                        <div class="px-md py-sm bg-surface-container-lowest border-t border-outline-variant flex items-center justify-between">
                            <span class="text-[11px] text-on-surface-variant">
                                {{ now()->lessThan($auction->end_time) ? 'Ends ' . $auction->end_time->diffForHumans() : 'Ended ' . $auction->end_time->format('M d, Y') }}
                            </span>

                            <a href="{{ route('auctions.show', $auction->id) }}" class="text-xs font-bold text-primary hover:underline flex items-center gap-0.5">
                                View Details
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
                    <span class="material-symbols-outlined text-3xl">inventory_2</span>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-on-surface">No Auctions Found</h3>
                    <p class="text-on-surface-variant text-sm max-w-sm mx-auto mt-1">You haven't listed any auctions yet. Start selling by creating your first auction!</p>
                </div>
                <a href="{{ route('auctions.create') }}" class="inline-flex items-center gap-xs bg-primary text-on-primary px-lg py-sm rounded-lg font-bold text-sm hover:brightness-110 transition-all">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    Create Auction
                </a>
            </div>
        @endif
    </div>
</x-layout>
