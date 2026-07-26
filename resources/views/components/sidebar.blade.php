<aside :class="collapsed ? 'w-20' : 'w-64'"
       class="h-full fixed left-0 top-0 bg-surface-container border-r border-outline-variant shadow-md flex flex-col py-md z-50 hidden md:flex transition-all duration-300 ease-in-out">

    <div class="px-md mb-xl flex items-center justify-between min-h-[40px]">
        <a href="{{ route('home') }}" x-show="!collapsed" x-transition.opacity class="font-headline-md text-headline-md text-primary font-bold whitespace-nowrap overflow-hidden">
            BidMaster Pro
        </a>

        <button @click="collapsed = !collapsed"
                class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container-highest transition-colors mx-auto">
            <span class="material-symbols-outlined" x-text="collapsed ? 'chevron_right' : 'chevron_left'"></span>
        </button>
    </div>

    <nav class="flex-1 space-y-1 px-2">
        <a href="{{ route('dashboard') }}"
           title="Dashboard"
           class="flex items-center px-md py-sm rounded-lg my-1 font-label-md text-label-md transition-all {{ request()->routeIs('dashboard') ? 'bg-primary-container text-on-primary-container font-bold' : 'text-on-surface-variant hover:bg-surface-container-highest' }}">
            <span class="material-symbols-outlined shrink-0">dashboard</span>
            <span x-show="!collapsed" x-transition.opacity class="ml-md whitespace-nowrap">Dashboard</span>
        </a>

        <a href="{{ route('bids.active') }}"
           title="Active Bids"
           class="flex items-center px-md py-sm rounded-lg my-1 font-label-md text-label-md transition-all {{ request()->routeIs('bids.active') ? 'bg-primary-container text-on-primary-container font-bold' : 'text-on-surface-variant hover:bg-surface-container-highest' }}">
            <span class="material-symbols-outlined shrink-0">gavel</span>
            <span x-show="!collapsed" x-transition.opacity class="ml-md whitespace-nowrap">Active Bids</span>
        </a>

        <a href="{{ route('auctions.my') }}"
           title="My Auctions"
           class="flex items-center px-md py-sm rounded-lg my-1 font-label-md text-label-md transition-all {{ request()->routeIs('auctions.my') ? 'bg-primary-container text-on-primary-container font-bold' : 'text-on-surface-variant hover:bg-surface-container-highest' }}">
            <span class="material-symbols-outlined shrink-0">inventory_2</span>
            <span x-show="!collapsed" x-transition.opacity class="ml-md whitespace-nowrap">My Auctions</span>
        </a>

        <a href="{{ route('settings.edit') }}"
           title="Settings"
           class="flex items-center px-md py-sm rounded-lg my-1 font-label-md text-label-md transition-all {{ request()->routeIs('settings.edit') ? 'bg-primary-container text-on-primary-container font-bold' : 'text-on-surface-variant hover:bg-surface-container-highest' }}">
            <span class="material-symbols-outlined shrink-0">settings</span>
            <span x-show="!collapsed" x-transition.opacity class="ml-md whitespace-nowrap">Settings</span>
        </a>
    </nav>

    @auth
        <div class="mt-auto px-md pt-md border-t border-outline-variant">
            <div class="flex items-center space-x-md mb-lg">
                <div class="w-10 h-10 rounded-full bg-surface-container-highest flex items-center justify-center shrink-0 border border-outline-variant text-primary font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div x-show="!collapsed" x-transition.opacity class="overflow-hidden whitespace-nowrap">
                    <p class="font-label-md text-label-md text-on-surface font-bold truncate">{{ auth()->user()->name }}</p>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">Verified Account</p>
                </div>
            </div>
        </div>
    @endauth
</aside>
