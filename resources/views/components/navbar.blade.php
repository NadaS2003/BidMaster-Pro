<header class="bg-surface-dim w-full h-16 border-b border-outline-variant shadow-sm sticky top-0 z-50">
    <div class="flex items-center justify-between px-lg w-full max-w-container-max mx-auto h-full">
        <div class="flex items-center gap-xl">
            <a href="{{ route('home') }}" class="font-display-lg text-2xl font-bold text-primary">BidMaster Pro</a>
            <nav class="hidden md:flex gap-md">
                <a class="text-primary font-bold border-b-2 border-primary pb-1 font-label-md text-label-md" href="{{ route('home') }}">Live Auctions</a>
                <a class="text-on-surface-variant hover:text-on-surface transition-colors duration-200 font-label-md text-label-md" href="#">Upcoming</a>
                <a class="text-on-surface-variant hover:text-on-surface transition-colors duration-200 font-label-md text-label-md" href="#">Results</a>
                <a class="text-on-surface-variant hover:text-on-surface transition-colors duration-200 font-label-md text-label-md" href="#">Categories</a>
            </nav>
        </div>

        <div class="flex items-center gap-md">
            @auth
                <a href="{{ route('auctions.create') }}" class="bg-primary/20 text-primary border border-primary px-md py-xs rounded-lg font-label-md text-label-md font-bold hover:bg-primary hover:text-on-primary transition-all flex items-center gap-xs">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    New Auction
                </a>
                <button class="material-symbols-outlined text-on-surface-variant hover:bg-surface-container-high transition-colors p-2 rounded-lg">notifications</button>
                <button class="material-symbols-outlined text-on-surface-variant hover:bg-surface-container-high transition-colors p-2 rounded-lg">history</button>
                <div class="flex items-center gap-sm">
                    <span class="text-sm font-medium text-on-surface hidden sm:inline">{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-xs text-red-400 hover:text-red-300 font-bold ml-2">Logout</button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="text-on-surface-variant hover:text-on-surface font-label-md text-label-md px-2 py-1">Login</a>
                <a href="{{ route('register') }}" class="bg-primary text-on-primary px-md py-xs rounded-lg font-label-md text-label-md font-bold hover:brightness-110 transition-all">Register</a>
            @endauth
        </div>
    </div>
</header>
