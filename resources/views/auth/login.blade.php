<!DOCTYPE html>

<html class="dark" lang="en"><head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login | BidMaster Pro</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=JetBrains+Mono:wght@400;500;700&amp;display=swap" rel="stylesheet"/>
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
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        .bidding-card-glow {
            box-shadow: 0px 0px 24px rgba(16, 185, 129, 0.08);
        }
        .input-focus-ring:focus {
            outline: none;
            border-color: #4edea3;
            box-shadow: 0 0 0 1px #4edea3;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="antialiased selection:bg-primary selection:text-on-primary">
<!-- Atmospheric Background Animation Overlay -->
<div class="fixed inset-0 z-0 pointer-events-none opacity-20">

</div>
<div class="relative z-10 min-h-screen flex flex-col items-center justify-center p-md">
    <!-- Login Container -->
    <div class="w-full max-w-[440px]">
        <!-- Branding Header -->
        <div class="flex flex-col items-center mb-xl">
            <div class="bg-primary-container p-sm rounded-lg mb-md shadow-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-on-primary-container text-[32px]" style="font-variation-settings: 'FILL' 1;">gavel</span>
            </div>
            <h1 class="font-display-lg text-headline-md text-primary tracking-tight">BidMaster Pro</h1>
            <p class="font-body-sm text-on-surface-variant mt-xs">Professional Real-Time Auction Access</p>
        </div>
        <!-- Login Card -->
        <div class="bg-surface-container-low border border-outline-variant p-lg rounded-xl shadow-2xl bidding-card-glow">
            <div class="mb-lg">
                <h2 class="font-headline-md text-on-surface">Welcome back</h2>
                <p class="font-body-sm text-on-surface-variant">Enter your credentials to access the bidding floor.</p>
            </div>
            <form action="{{ route('login') }}" class="space-y-md" method="POST">
                 @csrf
                <!-- Email Field -->
                <div class="space-y-xs">
                    <label class="font-label-md text-on-surface-variant block" for="email">Email Address</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">mail</span>
                        <input autocomplete="email" class="w-full bg-surface-container-highest border border-outline-variant rounded-lg py-2.5 pl-10 pr-4 text-on-surface font-body-md input-focus-ring transition-all placeholder:text-outline/50" id="email" name="email" placeholder="name@company.com" required="" type="email"/>
                    </div>
                 @error('email') <p class="text-error font-label-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Password Field -->
                <div class="space-y-xs">
                    <div class="flex justify-between items-center">
                        <label class="font-label-md text-on-surface-variant block" for="password">Password</label>
                        <a class="font-label-sm text-secondary hover:text-secondary-fixed transition-colors" href="#">Forgot Password?</a>
                    </div>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">lock</span>
                        <input autocomplete="current-password" class="w-full bg-surface-container-highest border border-outline-variant rounded-lg py-2.5 pl-10 pr-4 text-on-surface font-body-md input-focus-ring transition-all" id="password" name="password" required="" type="password"/>
                    </div>
                  @error('password') <p class="text-error font-label-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <!-- Remember Me & Policy -->
                <div class="flex items-center">
                    <input class="h-4 w-4 rounded border-outline-variant bg-surface-container-highest text-primary-container focus:ring-primary-container focus:ring-offset-surface-dim transition-all" id="remember" name="remember" type="checkbox"/>
                    <label class="ml-2 block font-body-sm text-on-surface-variant select-none" for="remember">
                        Keep me logged in for 30 days
                    </label>
                </div>
                <!-- Login Button -->
                <button class="w-full bg-primary-container hover:bg-primary text-on-primary-container font-headline-md py-3 rounded-lg shadow-lg hover:shadow-primary/20 active:scale-[0.98] transition-all flex items-center justify-center gap-2 mt-lg" type="submit">
                    <span>Sign In to Dashboard</span>
                    <span class="material-symbols-outlined">chevron_right</span>
                </button>
            </form>
            <!-- Footnote -->
            <div class="mt-lg pt-lg border-t border-outline-variant text-center">
                <p class="font-body-sm text-on-surface-variant">
                    Don't have a professional account?
                    <a class="text-primary font-medium hover:underline underline-offset-4 ml-1" href="#">Request Access</a>
                </p>
            </div>
        </div>
        <!-- Footer Meta -->
        <div class="mt-lg flex flex-col items-center gap-2">
            <div class="flex items-center gap-4 text-outline font-label-sm">
<span class="flex items-center gap-1">
<span class="material-symbols-outlined text-[14px]">verified_user</span>
                        QuantumShield Secured
                    </span>
                <span class="w-1 h-1 bg-outline-variant rounded-full"></span>
                <span>v2.4.0-stable</span>
            </div>
            <p class="text-outline/50 font-label-sm text-center">
                © 2024 BidMaster Pro. All systems operational.
            </p>
        </div>
    </div>
</div>
<!-- Micro-interaction Scripts -->
<script>
    // Subtle glow follow effect on the card
    const card = document.querySelector('.bidding-card-glow');
    document.addEventListener('mousemove', (e) => {
        if (!card) return;
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        // Only apply if mouse is somewhat near the card
        if (x > -100 && x < rect.width + 100 && y > -100 && y < rect.height + 100) {
            card.style.boxShadow = `${(x - rect.width/2)/20}px ${(y - rect.height/2)/20}px 30px rgba(16, 185, 129, 0.12)`;
        } else {
            card.style.boxShadow = '0px 0px 24px rgba(16, 185, 129, 0.08)';
        }
    });

    // Form submission feedback
    const form = document.querySelector('form');
    const btn = form.querySelector('button[type="submit"]');
    form.addEventListener('submit', () => {
        btn.innerHTML = '<span class="material-symbols-outlined animate-spin">refresh</span> <span>Verifying...</span>';
        btn.classList.add('opacity-80', 'cursor-not-allowed');
    });
</script>
</body></html>
