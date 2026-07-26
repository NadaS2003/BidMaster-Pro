<x-layout>
    <x-slot:title>Create New Auction | BidMaster Pro</x-slot:title>

    <div class="px-lg py-xl max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-lg">
            <h1 class="font-headline-lg text-headline-lg text-on-surface mb-xs">Create New Auction</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">List your professional assets in the marketplace. Fill in the technical specifications below to initiate the bidding process.</p>
        </div>

        <!-- Create Form -->
        <form action="{{ route('auctions.store') }}" method="POST" enctype="multipart/form-data" class="glass-card p-xl rounded-xl space-y-lg border border-outline-variant">
            @csrf

            <!-- Auction Media -->
            <div>
                <label class="block font-label-md text-label-md text-on-surface mb-sm">Auction Media</label>

                <label for="auction_image" class="border-2 border-dashed border-outline-variant rounded-xl p-xl flex flex-col items-center justify-center text-center cursor-pointer hover:border-primary transition-colors bg-surface-container-lowest">
                    <span class="material-symbols-outlined text-4xl text-on-surface-variant mb-sm" id="upload-icon">upload_file</span>
                    <p class="font-body-md text-body-md text-on-surface" id="upload-text">Drag and drop assets</p>
                    <p class="font-body-sm text-body-sm text-on-surface-variant" id="upload-subtext">High-resolution JPG, PNG or MP4 (Max 50MB)</p>

                    <input type="file" id="auction_image" name="image" class="hidden" accept="image/*,video/mp4" onchange="handleFileSelect(event)">
                </label>
                @error('image')
                    <p class="text-error text-body-sm mt-xs">{{ $message }}</p>
                @enderror
            </div>

            <!-- Auction Title -->
            <div>
                <label for="title" class="block font-label-md text-label-md text-on-surface mb-sm">Auction Title</label>
                <input type="text" id="title" name="title" required placeholder="e.g. Rare Vintage Chronograph 1954"
                       class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-md py-sm text-on-surface focus:border-primary outline-none">
                @error('title')
                <p class="text-error text-body-sm mt-xs">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pricing and Date -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                <div>
                    <label for="starting_price" class="block font-label-md text-label-md text-on-surface mb-sm">Starting Price</label>
                    <div class="relative">
                        <span class="absolute left-md top-1/2 -translate-y-1/2 text-on-surface-variant">$</span>
                        <input type="number" id="starting_price" name="starting_price" required placeholder="0.00"
                               class="w-full bg-surface-container-low border border-outline-variant rounded-lg pl-xl pr-md py-sm text-on-surface focus:border-primary outline-none">
                    </div>
                    @error('starting_price')
                    <p class="text-error text-body-sm mt-xs">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="end_time" class="block font-label-md text-label-md text-on-surface mb-sm">Auction Termination Date & Time</label>
                    <input type="datetime-local" id="end_time" name="end_time" required
                           class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-md py-sm text-on-surface focus:border-primary outline-none [color-scheme:dark]">
                    @error('end_time')
                    <p class="text-error text-body-sm mt-xs">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block font-label-md text-label-md text-on-surface mb-sm">Technical Specifications & Description</label>
                <textarea id="description" name="description" rows="5" required placeholder="Provide a detailed overview of the asset's history, condition, and value markers..."
                          class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-md py-sm text-on-surface focus:border-primary outline-none"></textarea>
                @error('description')
                <p class="text-error text-body-sm mt-xs">{{ $message }}</p>
                @enderror
            </div>

            <!-- Footer Actions -->
            <div class="pt-lg border-t border-outline-variant flex flex-col md:flex-row items-center justify-between gap-md">
                <div class="flex items-start gap-xs text-on-surface-variant font-body-sm">
                    <span class="material-symbols-outlined text-secondary">info</span>
                    <p class="max-w-md">By creating this auction, you agree to BidMaster Pro's liquidity terms and premium transaction fees.</p>
                </div>
                <div class="flex gap-md w-full md:w-auto">
                    <button type="button" class="flex-1 md:flex-none text-center bg-transparent border border-outline-variant text-on-surface px-xl py-sm rounded-lg font-label-md hover:bg-surface-container transition-all">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 md:flex-none text-center bg-primary text-on-primary px-xl py-sm rounded-lg font-label-md font-bold hover:brightness-110 active:scale-95 transition-all">
                        Create Auction
                    </button>
                </div>
            </div>
        </form>
    </div>
    <script>
        function handleFileSelect(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const fileName = input.files[0].name;
                document.getElementById('upload-icon').innerText = 'check_circle';
                document.getElementById('upload-icon').classList.add('text-primary');
                document.getElementById('upload-text').innerText = 'Selected: ' + fileName;
                document.getElementById('upload-subtext').innerText = 'Click again to change file';
            }
        }
    </script>
</x-layout>
