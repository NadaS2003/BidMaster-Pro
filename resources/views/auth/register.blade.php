<!DOCTYPE html>

<html class="dark" lang="en"><head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Register | BidMaster Pro</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=JetBrains+Mono:wght@400;500&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-dim": "#0b1326",
                        "secondary": "#ffb95f",
                        "outline": "#86948a",
                        "on-secondary-fixed-variant": "#653e00",
                        "on-secondary-container": "#5b3800",
                        "secondary-fixed": "#ffddb8",
                        "on-error": "#690005",
                        "on-surface-variant": "#bbcabf",
                        "on-surface": "#dae2fd",
                        "primary": "#4edea3",
                        "surface": "#0b1326",
                        "tertiary-fixed": "#e1e0ff",
                        "error": "#ffb4ab",
                        "outline-variant": "#3c4a42",
                        "surface-tint": "#4edea3",
                        "inverse-surface": "#dae2fd",
                        "on-tertiary-fixed": "#07006c",
                        "on-tertiary-container": "#1d17b2",
                        "surface-container-low": "#131b2e",
                        "surface-container-highest": "#2d3449",
                        "tertiary-container": "#9699ff",
                        "secondary-fixed-dim": "#ffb95f",
                        "surface-container": "#171f33",
                        "inverse-primary": "#006c49",
                        "secondary-container": "#ee9800",
                        "on-secondary": "#472a00",
                        "background": "#0b1326",
                        "on-primary": "#003824",
                        "on-secondary-fixed": "#2a1700",
                        "primary-container": "#10b981",
                        "inverse-on-surface": "#283044",
                        "on-primary-fixed-variant": "#005236",
                        "primary-fixed": "#6ffbbe",
                        "tertiary": "#c0c1ff",
                        "surface-variant": "#2d3449",
                        "surface-bright": "#31394d",
                        "on-error-container": "#ffdad6",
                        "tertiary-fixed-dim": "#c0c1ff",
                        "on-background": "#dae2fd",
                        "surface-container-high": "#222a3d",
                        "on-tertiary-fixed-variant": "#2f2ebe",
                        "on-primary-fixed": "#002113",
                        "on-tertiary": "#1000a9",
                        "error-container": "#93000a",
                        "primary-fixed-dim": "#4edea3",
                        "surface-container-lowest": "#060e20",
                        "on-primary-container": "#00422b"
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
                        "body-lg": ["Inter"],
                        "headline-lg": ["Inter"],
                        "label-md": ["JetBrains Mono"],
                        "headline-lg-mobile": ["Inter"],
                        "body-sm": ["Inter"]
                    },
                    "fontSize": {
                        "display-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "label-sm": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                        "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                        "label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.02em", "fontWeight": "500"}],
                        "headline-lg-mobile": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}]
                    }
                },
            },
        }
    </script>
    <style>
        body {
            background-color: #0b1326;
            background-image:
                radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(78, 222, 163, 0.05) 0px, transparent 50%);
        }
        .glass-card {
            background: rgba(23, 31, 51, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid #3c4a42;
        }
        .input-glow:focus {
            box-shadow: 0 0 0 2px rgba(78, 222, 163, 0.2);
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-md">
<main class="w-full max-w-[440px] animate-in fade-in zoom-in duration-500">
    <!-- Logo Section -->
    <div class="flex flex-col items-center mb-xl">
        <div class="flex items-center gap-sm mb-base">
            <span class="material-symbols-outlined text-primary text-[32px]" style="font-variation-settings: 'FILL' 1;">gavel</span>
            <h1 class="font-display-lg text-headline-md text-primary tracking-tight">BidMaster Pro</h1>
        </div>
        <p class="font-body-sm text-on-surface-variant">Smart Real-Time Auction Platform</p>
    </div>
    <!-- Registration Card -->
    <div class="glass-card rounded-xl shadow-2xl p-lg md:p-xl">
        <header class="mb-lg">
            <h2 class="font-headline-lg text-on-surface mb-xs">Create Account</h2>
            <p class="font-body-sm text-on-surface-variant">Join our professional bidding network.</p>
        </header>
        <form action="{{ route('register') }}" class="space-y-md" method="POST">
            <!-- CSRF Token Placeholder for Laravel -->
            @csrf
            <!-- Name Field -->
            <div class="space-y-xs">
                <label class="block font-label-md text-on-surface" for="name">Full Name</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-body-md">person</span>
                    <input class="w-full bg-surface-container-highest border border-outline-variant rounded-lg py-2.5 pl-10 pr-md text-on-surface font-body-md placeholder:text-outline focus:outline-none focus:border-primary input-glow transition-all" id="name" name="name" placeholder="John Doe" required="" type="text"/>
                </div>

                    @error('name')
                        <p class="text-error font-label-sm mt-1">{{ $message }}</p>
                    @enderror

            </div>
            <!-- Email Field -->
            <div class="space-y-xs">
                <label class="block font-label-md text-on-surface" for="email">Email Address</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-body-md">mail</span>
                    <input class="w-full bg-surface-container-highest border border-outline-variant rounded-lg py-2.5 pl-10 pr-md text-on-surface font-body-md placeholder:text-outline focus:outline-none focus:border-primary input-glow transition-all" id="email" name="email" placeholder="name@company.com" required="" type="email"/>
                </div>

                    @error('email')
                        <p class="text-error font-label-sm mt-1">{{ $message }}</p>
                    @enderror

            </div>
            <!-- Password Field -->
            <div class="space-y-xs">
                <label class="block font-label-md text-on-surface" for="password">Password</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-body-md">lock</span>
                    <input class="w-full bg-surface-container-highest border border-outline-variant rounded-lg py-2.5 pl-10 pr-md text-on-surface font-body-md placeholder:text-outline focus:outline-none focus:border-primary input-glow transition-all" id="password" name="password" placeholder="••••••••" required="" type="password"/>
                </div>
                <!--
                    @error('password')
                <p class="text-error font-label-sm mt-1">{{ $message }}</p>
                    @enderror
                -->
            </div>
            <!-- Confirm Password Field -->
            <div class="space-y-xs">
                <label class="block font-label-md text-on-surface" for="password_confirmation">Confirm Password</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-body-md">lock_reset</span>
                    <input class="w-full bg-surface-container-highest border border-outline-variant rounded-lg py-2.5 pl-10 pr-md text-on-surface font-body-md placeholder:text-outline focus:outline-none focus:border-primary input-glow transition-all" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required="" type="password"/>
                </div>
            </div>
            <div class="pt-sm">
                <button class="w-full bg-primary-container hover:bg-primary text-on-primary-container font-headline-md py-3 rounded-lg flex items-center justify-center gap-sm transition-all active:scale-[0.98] shadow-lg shadow-primary/10" type="submit">
                    <span>Create Account</span>
                    <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                </button>
            </div>
        </form>
        <footer class="mt-lg pt-lg border-t border-outline-variant text-center">
            <p class="font-body-sm text-on-surface-variant">
                Already have an account?
                <a class="text-primary font-medium hover:underline transition-all" href="#">Log in</a>
            </p>
        </footer>
    </div>
    <!-- Trust Badges / Info -->
    <div class="mt-lg flex justify-between px-sm">
        <div class="flex items-center gap-xs text-on-surface-variant">
            <span class="material-symbols-outlined text-[16px]">verified_user</span>
            <span class="font-label-sm">Secure Bidding</span>
        </div>
        <div class="flex items-center gap-xs text-on-surface-variant">
            <span class="material-symbols-outlined text-[16px]">timer</span>
            <span class="font-label-sm">Real-time Sync</span>
        </div>
    </div>
</main>
<script>
    // Simple interactivity for input focus states
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.parentElement.querySelector('.material-symbols-outlined').style.color = '#4edea3';
        });
        input.addEventListener('blur', () => {
            input.parentElement.querySelector('.material-symbols-outlined').style.color = '';
        });
    });
</script>
</body></html>
