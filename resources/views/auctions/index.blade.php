<x-layout>
    <x-slot:title>BidMaster Pro | Live Auctions</x-slot:title>

    <form action="{{ route('home') }}" method="GET" class="bg-surface-container/60 p-2 rounded-2xl border border-outline-variant flex flex-col md:flex-row items-center gap-2">

        <div class="relative flex-1 w-full flex items-center">
            <span class="material-symbols-outlined absolute left-3 text-on-surface-variant text-[20px]">search</span>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search auctions for rare collectibles, industrial gear, or tech..."
                class="w-full bg-transparent pl-10 pr-4 py-2 text-sm text-on-surface border-none outline-none focus:outline-none focus:ring-0 focus:border-none shadow-none placeholder:text-on-surface-variant/70"
            >

            @if(request('search'))
                <a href="{{ route('home') }}" class="text-on-surface-variant hover:text-on-surface pr-2 text-xs">Clear</a>
            @endif
        </div>

    </form>

    <section class="px-lg pb-xl max-w-container-max mx-auto mt-lg">
        <div class="flex items-center justify-between mb-lg">
            <h2 class="font-headline-lg text-headline-lg text-on-surface flex items-center gap-sm">
                Live Now <span class="w-3 h-3 bg-primary rounded-full animate-pulse"></span>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-lg">
            @forelse($auctions as $auction)
                <x-auction-card :auction="$auction" />
            @empty
                <div class="col-span-full bg-surface-container border border-outline-variant p-12 text-center rounded-xl text-on-surface-variant">
                    No active auctions found at the moment.
                </div>
            @endforelse
        </div>

        <div class="mt-xl pt-lg border-t border-outline-variant">
            {{ $auctions->links() }}
        </div>
    </section>
</x-layout>
