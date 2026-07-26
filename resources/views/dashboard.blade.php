<x-layout>
    <x-slot:title>Dashboard - BidMaster Pro</x-slot:title>

    <div class="space-y-lg">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-md">
            <div>
                <h1 class="font-display-lg text-2xl font-bold text-on-surface">Dashboard</h1>
                <p class="font-body-sm text-on-surface-variant">Welcome back, {{ auth()->user()->name }}!</p>
            </div>

        </div>

        <div class="mt-6">

                <div class="flex flex-col lg:flex-row gap-6 items-stretch">

                    @if(auth()->check())
                        @php
                            $userTier = auth()->user()->tier;
                        @endphp

                        @if($userTier !== \App\Enums\UserTier::VIP)
                            <div class="mb-6 p-6 rounded-2xl bg-gradient-to-r from-amber-950/40 via-surface-container to-surface-container-high border border-amber-500/30 flex flex-col sm:flex-row justify-between items-center gap-4 shadow-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="p-3 bg-amber-500/20 text-amber-400 rounded-xl">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        @if($userTier === \App\Enums\UserTier::STANDARD)
                                            <h4 class="text-amber-400 font-bold text-base">Unlock Gold Tier Auctions!</h4>
                                            <p class="text-on-surface-variant text-xs mt-1">Upgrade from Standard to Gold to access exclusive high-value auctions and priority bidding.</p>
                                        @elseif($userTier === \App\Enums\UserTier::GOLD)
                                            <h4 class="text-amber-400 font-bold text-base">Upgrade to Elite VIP Status!</h4>
                                            <p class="text-on-surface-variant text-xs mt-1">You are a Gold member. Win 2 auctions to unlock the ultimate VIP tier benefits.</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- زر الترقية -->
                                <form action="{{ route('tier.upgrade') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold px-5 py-2.5 rounded-xl text-xs transition shadow-md flex-shrink-0">
                                        @if($userTier === \App\Enums\UserTier::STANDARD) Upgrade to Gold @else Upgrade to VIP @endif
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endif
                    <div class="w-full lg:w-1/3 bg-surface-container border border-outline-variant rounded-2xl p-4 shadow-lg flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-center mb-3 pb-2 border-b border-outline-variant">
                                <h3 class="text-on-surface font-bold text-sm flex items-center gap-2">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Ending Soon
                                </h3>
                                <span class="text-[10px] text-on-surface-variant">Act fast!</span>
                            </div>

                            <div class="space-y-3 max-h-[300px] overflow-y-auto">
                                @forelse($endingSoonAuctions ?? [] as $auction)
                                    <div class="bg-surface-container-high/50 border border-outline-variant rounded-xl p-3 flex flex-col justify-between hover:border-amber-500/50 transition">
                                        <div>
                                            <div class="flex justify-between items-center mb-1">
                                        <span class="bg-red-500/10 text-red-400 text-[9px] font-bold px-2 py-0.5 rounded-full flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span> Ending
                                        </span>
                                                <span class="text-[10px] text-amber-400 font-semibold">{{ \Carbon\Carbon::parse($auction->end_time)->diffForHumans() }}</span>
                                            </div>
                                            <h4 class="text-on-surface font-bold text-xs truncate">{{ $auction->title }}</h4>
                                            <p class="text-on-surface-variant text-[11px] mt-0.5">Bid: <span class="text-primary font-bold">${{ $auction->current_bid ?? $auction->starting_price }}</span></p>
                                        </div>

                                        <a href="{{ route('auctions.show', $auction->id) }}" class="mt-2 text-center bg-surface-container hover:bg-amber-500 hover:text-slate-950 text-on-surface text-[11px] font-bold py-1.5 rounded-lg transition">
                                            Place Bid
                                        </a>
                                    </div>
                                @empty
                                    <div class="p-4 text-center text-on-surface-variant text-xs">
                                        No auctions ending soon.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                </div>

        </div>


        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-md">
            <div class="bg-surface-container p-lg rounded-xl border border-outline-variant flex items-center justify-between">
                <div>
                    <p class="text-on-surface-variant font-label-md">Active Auctions Bidded</p>
                    <h3 class="text-3xl font-bold text-primary mt-1">{{ $activeBidsCount }}</h3>
                </div>
                <span class="material-symbols-outlined text-primary text-3xl p-3 bg-primary/10 rounded-xl">gavel</span>
            </div>

            <div class="bg-surface-container p-lg rounded-xl border border-outline-variant flex items-center justify-between">
                <div>
                    <p class="text-on-surface-variant font-label-md">My Auctions</p>
                    <h3 class="text-3xl font-bold text-primary mt-1">{{ $myAuctionsCount }}</h3>
                </div>
                <span class="material-symbols-outlined text-primary text-3xl p-3 bg-primary/10 rounded-xl">inventory_2</span>
            </div>

            <div class="bg-surface-container p-lg rounded-xl border border-outline-variant flex items-center justify-between sm:col-span-2 md:col-span-1">
                <div>
                    <p class="text-on-surface-variant font-label-md">Total Bids Placed</p>
                    <h3 class="text-3xl font-bold text-primary mt-1">{{ $totalBidsCount }}</h3>
                </div>
                <span class="material-symbols-outlined text-primary text-3xl p-3 bg-primary/10 rounded-xl">history</span>
            </div>
        </div>

        <div class="bg-surface-container p-lg rounded-xl border border-outline-variant space-y-md">
            <h2 class="font-headline-md text-lg font-bold text-on-surface">Recent Bidding Activity</h2>

            <div class="overflow-x-auto">
                <table class="w-full text-left font-body-sm text-on-surface-variant">
                    <thead class="border-b border-outline-variant text-on-surface">
                    <tr>
                        <th class="py-3 px-2">Item</th>
                        <th class="py-3 px-2">Your Last Bid</th>
                        <th class="py-3 px-2">Date</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/40">
                    @forelse ($recentBids as $bid)
                        <tr>
                            <td class="py-3 px-2 font-medium text-on-surface">
                                {{ $bid->auction->title ?? 'N/A' }}
                            </td>
                            <td class="py-3 px-2 text-primary font-bold">
                                ${{ number_format($bid->amount, 2) }}
                            </td>
                            <td class="py-3 px-2">
                                {{ $bid->created_at->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-6 text-center text-on-surface-variant">
                                No recent bidding activity found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                </svg>
                <h3 class="text-on-surface font-bold text-lg">My Badges & Achievements</h3>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                @forelse($badges ?? [] as $badge)
                    @if($badge->is_unlocked)

                        <div class="bg-surface-container border border-amber-500/30 rounded-2xl p-4 flex flex-col items-center text-center relative overflow-hidden group shadow-md hover:border-amber-500 transition">
                            <div class="absolute inset-0 bg-gradient-to-b from-amber-500/10 to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                            <div class="w-14 h-14 bg-amber-500/20 rounded-full flex items-center justify-center mb-3 text-2xl">
                                {{ $badge->icon_path ?? '🏆' }}
                            </div>
                            <h4 class="text-amber-400 font-bold text-sm">{{ $badge->name }}</h4>
                            <p class="text-on-surface-variant text-[11px] mt-1">{{ $badge->description }}</p>
                        </div>
                    @else

                        <div class="bg-surface-container/40 border border-outline-variant border-dashed rounded-2xl p-4 flex flex-col items-center text-center opacity-60 hover:opacity-100 transition">
                            <div class="w-14 h-14 bg-surface-container-high rounded-full flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-on-surface-variant" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <h4 class="text-on-surface font-bold text-sm">{{ $badge->name }}</h4>
                            <p class="text-on-surface-variant text-[11px] mt-1">{{ $badge->description }}</p>
                        </div>
                    @endif
                @empty
                    <div class="col-span-full text-center text-on-surface-variant text-xs py-4">
                        No badges available yet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layout>
