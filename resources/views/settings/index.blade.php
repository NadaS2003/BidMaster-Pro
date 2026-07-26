<x-layout>
    <x-slot:title>Account Settings - BidMaster Pro</x-slot:title>

    <div class="space-y-lg max-w-4xl mx-auto">
        <!-- Page Header -->
        <div>
            <h1 class="font-display-lg text-2xl font-bold text-on-surface">Account Settings</h1>
            <p class="font-body-sm text-on-surface-variant">Manage your personal account parameters, security settings, and preferences.</p>
        </div>

        <!-- Section 1: Profile Information -->
        <div class="bg-surface-container p-lg rounded-xl border border-outline-variant space-y-md">
            <div>
                <h2 class="text-lg font-bold text-on-surface flex items-center gap-xs">
                    <span class="material-symbols-outlined text-primary">person</span>
                    Profile Information
                </h2>
                <p class="text-xs text-on-surface-variant mt-0.5">Update your account's profile name and email address.</p>
            </div>

            <!-- Success Alert for Profile -->
            @if (session('success_profile'))
                <div class="p-md bg-green-500/10 border border-green-500/30 text-green-400 rounded-lg flex items-center gap-xs text-xs font-bold">
                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                    {{ session('success_profile') }}
                </div>
            @endif

            <form action="{{ route('settings.update-profile') }}" method="POST" class="space-y-md">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-xs font-bold text-on-surface mb-1.5">Full Name</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg p-2.5 text-on-surface text-sm focus:border-primary outline-none"
                            required
                        >
                        @error('name')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-on-surface mb-1.5">Email Address</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg p-2.5 text-on-surface text-sm focus:border-primary outline-none"
                            required
                        >
                        @error('email')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="bg-primary text-on-primary px-lg py-sm rounded-lg font-bold text-xs hover:brightness-110 active:scale-95 transition-all">
                        Save Profile Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Section 2: Update Password -->
        <div class="bg-surface-container p-lg rounded-xl border border-outline-variant space-y-md">
            <div>
                <h2 class="text-lg font-bold text-on-surface flex items-center gap-xs">
                    <span class="material-symbols-outlined text-primary">lock</span>
                    Update Password
                </h2>
                <p class="text-xs text-on-surface-variant mt-0.5">Ensure your account is using a long, random password to stay secure.</p>
            </div>

            <!-- Success Alert for Password -->
            @if (session('success_password'))
                <div class="p-md bg-green-500/10 border border-green-500/30 text-green-400 rounded-lg flex items-center gap-xs text-xs font-bold">
                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                    {{ session('success_password') }}
                </div>
            @endif

            <form action="{{ route('settings.update-password') }}" method="POST" class="space-y-md">
                @csrf
                @method('PUT')

                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-xs font-bold text-on-surface mb-1.5">Current Password</label>
                    <input
                        type="password"
                        id="current_password"
                        name="current_password"
                        class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg p-2.5 text-on-surface text-sm focus:border-primary outline-none"
                        required
                    >
                    @error('current_password')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-xs font-bold text-on-surface mb-1.5">New Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg p-2.5 text-on-surface text-sm focus:border-primary outline-none"
                            required
                        >
                        @error('password')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-on-surface mb-1.5">Confirm New Password</label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg p-2.5 text-on-surface text-sm focus:border-primary outline-none"
                            required
                        >
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="bg-primary text-on-primary px-lg py-sm rounded-lg font-bold text-xs hover:brightness-110 active:scale-95 transition-all">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
