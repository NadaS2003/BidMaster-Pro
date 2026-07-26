@props(['auction'])

<div class="glass-card rounded-xl overflow-hidden flex flex-col group hover:border-primary transition-all duration-300 live-glow">
    <div class="relative h-48 overflow-hidden">
        @if($auction->image_path)
            <img src="{{ asset('storage/' . $auction->image_path) }}" alt="{{ $auction->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @else
            <div class="w-full h-full bg-surface-container-highest flex items-center justify-center text-on-surface-variant text-sm font-label-md">
                No Image Available
            </div>
        @endif

        <div class="absolute top-md left-md bg-primary/20 backdrop-blur-md border border-primary px-sm py-1 rounded-full flex items-center gap-1">
            <span class="w-1.5 h-1.5 bg-primary rounded-full animate-pulse"></span>
            <span class="text-primary font-label-sm text-label-sm uppercase tracking-wider font-bold">Live</span>
        </div>

        <div class="absolute bottom-md right-md bg-surface-dim/80 backdrop-blur-md px-sm py-1 rounded border border-outline-variant">
            <span class="text-on-surface font-label-sm text-label-sm flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px]">timer</span>
                {{ $auction->end_time ? $auction->end_time->format('H:i:s') : 'Live' }}
            </span>
        </div>
    </div>

    <div class="p-md flex-grow flex flex-col">
        <h3 class="font-headline-md text-headline-md text-on-surface mb-xs truncate">{{ $auction->title }}</h3>
        <p class="font-body-sm text-body-sm text-on-surface-variant mb-md line-clamp-2">{{ $auction->description }}</p>

        <div class="mt-auto flex justify-between items-end mb-md">
            <div>
                <span class="block font-label-sm text-label-sm text-on-surface-variant">CURRENT BID</span>
                <span class="font-label-md text-label-md text-secondary font-bold text-xl">
                    ${{ number_format($auction->current_price ?? $auction->starting_price, 2) }}
                </span>
            </div>
            <span class="text-on-surface-variant font-label-sm text-label-sm">
                {{ $auction->bids_count ?? ($auction->bids ? $auction->bids->count() : 0) }} Bids
            </span>
        </div>

        <a href="{{ route('auctions.show', $auction->id) }}" class="w-full text-center bg-secondary-container text-on-secondary px-md py-sm rounded-lg font-label-md text-label-md font-bold hover:brightness-110 active:scale-95 transition-all">
            View Auction
        </a>
    </div>
</div>
