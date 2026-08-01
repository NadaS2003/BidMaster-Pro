<x-layout>
    <x-slot:title>Auction Results - BidMaster Pro</x-slot:title>

    <div class="space-y-lg">

        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-on-surface flex items-center gap-2">
                Concluded Auction Results
                <span class="w-2.5 h-2.5 rounded-full bg-gray-500"></span>
            </h2>
        </div>

        <!-- Grid -->
        @if($auctions->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-md">
                @foreach($auctions as $auction)
                    <div class="bg-surface-container rounded-xl border border-outline-variant overflow-hidden flex flex-col justify-between opacity-90 hover:opacity-100 transition-all">
                        <div class="relative h-44 bg-surface-container-highest flex items-center justify-center">
                            @if($auction->image_path)
                                <img src="{{ $auction->image_path }}" class="w-full h-full object-cover grayscale opacity-80">
                            @else
                                <span class="text-xs text-on-surface-variant">No Image Available</span>
                            @endif

                            <span class="absolute top-3 left-3 bg-surface-container-highest text-on-surface-variant border border-outline-variant text-[10px] font-bold px-2 py-0.5 rounded-full">
                                ENDED
                            </span>
                        </div>

                        <div class="p-md space-y-sm">
                            <h3 class="font-bold text-on-surface text-sm line-clamp-1">{{ $auction->title }}</h3>

                            <div class="pt-2 border-t border-outline-variant/40 flex justify-between text-xs">
                                <div>
                                    <span class="text-on-surface-variant text-[10px] block">FINAL PRICE</span>
                                    <span class="font-bold text-primary">${{ number_format($auction->final_price ?? $auction->starting_price, 2) }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-on-surface-variant text-[10px] block">TOTAL BIDS</span>
                                    <span class="font-bold text-on-surface">{{ $auction->bids_count }} Bids</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-md pt-0">
                            <a href="{{ route('auctions.show', $auction->id) }}" class="w-full block text-center bg-surface-container-highest text-on-surface border border-outline-variant py-2 rounded-lg text-xs font-bold hover:bg-surface-container-low transition-all">
                                View Final Result
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div>{{ $auctions->links() }}</div>
        @else
            <div class="p-xl text-center text-on-surface-variant bg-surface-container rounded-xl border border-outline-variant">
                No past auction results found.
            </div>
        @endif
    </div>
</x-layout>
