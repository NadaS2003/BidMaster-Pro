<!DOCTYPE html>
<html lang="ar" dir="ltr" class="dark">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ $title ?? 'BidMaster Pro | Smart Real-Time Auction Platform' }}</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-dim": "#0b1326",
                        "secondary": "#ffb95f",
                        "outline": "#86948a",
                        "on-surface-variant": "#bbcabf",
                        "on-surface": "#dae2fd",
                        "primary": "#4edea3",
                        "surface": "#0b1326",
                        "outline-variant": "#3c4a42",
                        "surface-container-low": "#131b2e",
                        "surface-container-highest": "#2d3449",
                        "surface-container": "#171f33",
                        "secondary-container": "#ee9800",
                        "on-secondary": "#472a00",
                        "background": "#0b1326",
                        "on-primary": "#003824",
                        "surface-container-high": "#222a3d",
                        "surface-container-lowest": "#060e20"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "lg": "24px",
                        "gutter": "20px",
                        "sm": "8px",
                        "xl": "40px",
                        "base": "4px",
                        "md": "16px",
                        "xs": "4px",
                        "container-max": "1440px"
                    },
                    "fontFamily": {
                        "display-lg": ["Inter"],
                        "headline-md": ["Inter"],
                        "body-md": ["Inter"],
                        "label-sm": ["JetBrains Mono"],
                        "label-md": ["JetBrains Mono"]
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #060e20;
            color: #dae2fd;
            font-family: 'Inter', sans-serif;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .live-glow {
            box-shadow: 0px 0px 12px rgba(16, 185, 129, 0.2);
        }
        .glass-card {
            background: rgba(23, 31, 51, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(60, 74, 66, 0.5);
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @auth
        <meta name="user-id" content="{{ auth()->id() }}">
    @endauth
</head>
<body x-data="{ collapsed: false }" class="bg-surface-dim text-on-surface font-body-md min-h-screen flex flex-col selection:bg-primary selection:text-on-primary">

@auth
    <x-sidebar />
@endauth

<div :class="{
            'md:ml-20': collapsed && {{ auth()->check() ? 'true' : 'false' }},
            'md:ml-64': !collapsed && {{ auth()->check() ? 'true' : 'false' }}
         }"
     class="flex-grow flex flex-col min-h-screen transition-all duration-300 ease-in-out">

    <header class="bg-surface-dim w-full h-16 border-b border-outline-variant shadow-sm sticky top-0 z-40">
        <div class="flex items-center justify-between px-lg w-full max-w-container-max mx-auto h-full">
            <div class="flex items-center gap-xl">
                @guest
                    <a href="{{ route('home') }}" class="font-display-lg text-2xl font-bold text-primary">BidMaster Pro</a>
                @endguest

                <nav class="hidden md:flex gap-md">
                    <div class="flex items-center gap-md font-label-md text-sm">
                        <!-- Live Auctions Tab -->
                        <a href="{{ route('home') }}"
                           class="pb-1 transition-colors border-b-2 {{ request()->routeIs('home') ? 'text-primary border-primary font-bold' : 'text-on-surface-variant border-transparent hover:text-on-surface' }}">
                            Live Auctions
                        </a>

                        <!-- Upcoming Tab -->
                        <a href="{{ route('auctions.upcoming') }}"
                           class="pb-1 transition-colors border-b-2 {{ request()->routeIs('auctions.upcoming') ? 'text-primary border-primary font-bold' : 'text-on-surface-variant border-transparent hover:text-on-surface' }}">
                            Upcoming
                        </a>

                        <!-- Results Tab -->
                        <a href="{{ route('auctions.results') }}"
                           class="pb-1 transition-colors border-b-2 {{ request()->routeIs('auctions.results') ? 'text-primary border-primary font-bold' : 'text-on-surface-variant border-transparent hover:text-on-surface' }}">
                            Results
                        </a>
                    </div>
                </nav>
            </div>

            <div class="flex items-center gap-md">
                @auth
                    <a href="{{ route('auctions.create') }}" class="bg-primary/20 text-primary border border-primary px-md py-xs rounded-lg font-label-md text-label-md font-bold hover:bg-primary hover:text-on-primary transition-all flex items-center gap-xs">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                        New Auction
                    </a>
                    <div x-data="{ open: false }" class="relative">
                        <button
                            @click="open = !open"
                            class="relative material-symbols-outlined text-on-surface-variant hover:bg-surface-container-high transition-colors p-2 rounded-lg">
                            notifications
                            @if(auth()->user()->unreadNotifications->count())
                                <span class="absolute top-0 right-0 bg-red-500 text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
                            @endif
                        </button>

                        <div
                            x-show="open"
                            @click.outside="open = false"
                            x-transition
                            class="absolute right-0 mt-3 w-80 bg-surface-container border border-outline-variant rounded-lg shadow-xl overflow-hidden z-50">

                            <!-- رأس القائمة مع زر قراءة الكل -->
                            <div class="px-4 py-3 border-b border-outline-variant flex justify-between items-center">
                                <h3 class="font-bold text-on-surface text-sm">
                                    Notifications
                                </h3>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <form action="{{ route('notifications.readAll') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-[11px] text-indigo-400 hover:text-indigo-300 font-medium transition">
                                            Mark all as read
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <!-- قائمة الإشعارات -->
                            <div class="max-h-96 overflow-y-auto">
                                @forelse(auth()->user()->notifications as $notification)
                                    <div class="px-4 py-3 border-b border-outline-variant hover:bg-surface-container-high transition flex justify-between items-start gap-2 {{ is_null($notification->read_at) ? 'bg-surface-container-high/40' : '' }}">

                                        <!-- محتوى الإشعار -->
                                        <div>
                                            <p class="text-primary font-bold text-sm">
                                                {{ $notification->data['title'] ?? 'Notification' }}
                                            </p>
                                            <p class="text-on-surface-variant text-xs mt-1">
                                                {{ $notification->data['message'] ?? '' }}
                                            </p>
                                            <span class="text-[10px] text-gray-400 block mt-1">
                            {{ $notification->created_at->diffForHumans() }}
                        </span>
                                        </div>

                                        <!-- زر تحديد إشعار واحد كمقروء -->
                                        @if(is_null($notification->read_at))
                                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="flex-shrink-0">
                                                @csrf
                                                <button type="submit" title="Mark as read" class="text-gray-400 hover:text-indigo-400 p-1 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                @empty
                                    <div class="p-6 text-center text-on-surface-variant text-sm">
                                        No notifications
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

{{--                    <button class="material-symbols-outlined text-on-surface-variant hover:bg-surface-container-high transition-colors p-2 rounded-lg">history</button>--}}

                    <div class="flex items-center gap-sm">
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-xs text-red-400 hover:text-red-300 ml-2 font-bold">Logout</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-on-surface-variant hover:text-on-surface font-label-md text-label-md px-2 py-1">Login</a>
                    <a href="{{ route('register') }}" class="bg-primary text-on-primary px-md py-xs rounded-lg font-label-md text-label-md font-bold hover:brightness-110 transition-all">Register</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="flex-grow p-md md:p-lg">
        @if(session('error'))
            <div class="relative mb-6 p-4 rounded-lg border border-red-800 bg-red-950/50 text-red-400 flex items-center space-x-3 shadow-inner" role="alert">
                <svg class="w-6 h-6 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <span class="block sm:inline font-medium">{{ session('error') }}</span>
                <button onclick="this.parentElement.style.display='none'" class="absolute top-2 right-2 text-red-600 hover:text-red-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        @endif

            @if(session('success'))
                <div class="relative mb-6 p-4 rounded-lg border border-emerald-800 bg-emerald-950/50 text-emerald-400 flex items-center space-x-3 shadow-inner" role="alert">
                    <svg class="w-6 h-6 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="block sm:inline font-medium text-xs">{{ session('success') }}</span>
                    <button onclick="this.parentElement.style.display='none'" class="absolute top-2 right-2 text-emerald-600 hover:text-emerald-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            @endif
        {{ $slot }}
    </main>

    <footer class="bg-surface-container-lowest w-full py-xl border-t border-outline-variant mt-auto">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center px-lg max-w-container-max mx-auto gap-xl">
            <div class="flex flex-col gap-sm">
                <span class="font-headline-md text-headline-md text-on-surface font-bold">BidMaster Pro</span>
                <p class="font-body-sm text-body-sm text-on-surface-variant max-w-xs">The gold standard for high-stakes digital auctions.</p>
            </div>
            <div class="flex flex-wrap gap-lg">
                <a class="text-on-surface-variant hover:text-secondary transition-colors font-label-sm text-label-sm" href="#">Terms of Service</a>
                <a class="text-on-surface-variant hover:text-secondary transition-colors font-label-sm text-label-sm" href="#">Privacy Policy</a>
            </div>
        </div>
    </footer>

</div>

</body>
</html>
