<x-layout>
    <x-slot:title>Upcoming Auctions - BidMaster Pro</x-slot:title>

    <div class="space-y-lg">

        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-on-surface flex items-center gap-2">
                Upcoming Listings
                <span class="w-2.5 h-2.5 rounded-full bg-blue-400"></span>
            </h2>
        </div>

        <!-- Grid -->
        @if($auctions->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-md">
                @foreach($auctions as $auction)
                    <div class="bg-surface-container rounded-xl border border-outline-variant overflow-hidden flex flex-col justify-between">
                        <div class="relative h-44 bg-surface-container-highest flex items-center justify-center">
                            @if($auction->image_path)
                                <img src="{{ asset('storage/' . $auction->image_path) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-xs text-on-surface-variant">No Image Available</span>
                            @endif

                            <span class="absolute top-3 left-3 bg-blue-500/20 text-blue-400 border border-blue-500/40 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                UPCOMING
                            </span>
                        </div>

                        <div class="p-md space-y-sm">
                            <h3 class="font-bold text-on-surface text-sm line-clamp-1">{{ $auction->title }}</h3>
                            <p class="text-xs text-on-surface-variant line-clamp-2">{{ $auction->description }}</p>

                            <div class="pt-2 border-t border-outline-variant/40 flex justify-between text-xs">
                                <div>
                                    <span class="text-on-surface-variant text-[10px] block">STARTING PRICE</span>
                                    <span class="font-bold text-primary">${{ number_format($auction->starting_price, 2) }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-on-surface-variant text-[10px] block">STARTS IN</span>
                                    <span class="font-bold text-on-surface">{{ $auction->start_time ? $auction->start_time->diffForHumans() : 'Soon' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-md pt-0">
                            <a href="{{ route('auctions.show', $auction->id) }}" class="w-full block text-center bg-surface-container-highest text-on-surface border border-outline-variant py-2 rounded-lg text-xs font-bold hover:bg-surface-container-low transition-all">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div>{{ $auctions->links() }}</div>
        @else
            <div class="p-xl text-center text-on-surface-variant bg-surface-container rounded-xl border border-outline-variant">
                No upcoming auctions scheduled at the moment.
            </div>
        @endif
    </div>
</x-layout>
