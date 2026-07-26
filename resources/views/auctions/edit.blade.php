<x-layout>
    <x-slot:title>Edit Auction | {{ $auction->title }}</x-slot:title>

    <div class="px-lg py-xl max-w-4xl mx-auto">
        <div class="mb-lg">
            <h1 class="font-headline-lg text-headline-lg text-on-surface mb-xs">Edit Auction</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">Update the details and specifications for your listed asset.</p>
        </div>

        <form action="{{ route('auctions.update', $auction->id) }}" method="POST" enctype="multipart/form-data" class="glass-card p-xl rounded-xl space-y-lg border border-outline-variant">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-label-md text-label-md text-on-surface mb-sm">Auction Media</label>

                @if ($auction->image_path)
                    <div class="mb-md p-md bg-surface-container-lowest rounded-xl border border-outline-variant flex items-center gap-md">
                        <img src="{{ asset('storage/' . $auction->image_path) }}" alt="{{ $auction->title }}" class="w-20 h-20 object-cover rounded-lg border border-outline-variant">
                        <div>
                            <p class="font-label-md text-on-surface">Current Image</p>
                            <p class="font-body-sm text-on-surface-variant text-xs">Uploading a new file will replace the current media.</p>
                        </div>
                    </div>
                @endif

                <label for="auction_image" class="border-2 border-dashed border-outline-variant rounded-xl p-xl flex flex-col items-center justify-center text-center cursor-pointer hover:border-primary transition-colors bg-surface-container-lowest">
                    <span class="material-symbols-outlined text-4xl text-on-surface-variant mb-sm" id="upload-icon">upload_file</span>
                    <p class="font-body-md text-body-md text-on-surface" id="upload-text">Drag and drop new assets to replace</p>
                    <p class="font-body-sm text-body-sm text-on-surface-variant" id="upload-subtext">High-resolution JPG, PNG or MP4 (Max 50MB)</p>

                    <input type="file" id="auction_image" name="image" class="hidden" accept="image/*,video/mp4" onchange="handleFileSelect(event)">
                </label>
                @error('image')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="title" class="block font-label-md text-label-md text-on-surface mb-sm">Auction Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $auction->title) }}" required placeholder="e.g. Rare Vintage Chronograph 1954"
                       class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-md py-sm text-on-surface focus:border-primary outline-none">
                @error('title')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                <div>
                    <label for="starting_price" class="block font-label-md text-label-md text-on-surface mb-sm">Starting Price</label>
                    <div class="relative">
                        <span class="absolute left-md top-1/2 -translate-y-1/2 text-on-surface-variant">$</span>
                        <input type="number" step="0.01" id="starting_price" name="starting_price" value="{{ old('starting_price', $auction->starting_price) }}" required placeholder="0.00"
                               class="w-full bg-surface-container-low border border-outline-variant rounded-lg pl-xl pr-md py-sm text-on-surface focus:border-primary outline-none">
                    </div>
                    @error('starting_price')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="end_time" class="block font-label-md text-label-md text-on-surface mb-sm">Auction Termination Date & Time</label>
                    <input type="datetime-local" id="end_time" name="end_time"
                           value="{{ old('end_time', $auction->end_time ? \Carbon\Carbon::parse($auction->end_time)->format('Y-m-d\TH:i') : '') }}" required
                           class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-md py-sm text-on-surface focus:border-primary outline-none [color-scheme:dark]">
                    @error('end_time')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="description" class="block font-label-md text-label-md text-on-surface mb-sm">Technical Specifications & Description</label>
                <textarea id="description" name="description" rows="5" required placeholder="Provide a detailed overview of the asset's history..."
                          class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-md py-sm text-on-surface focus:border-primary outline-none">{{ old('description', $auction->description) }}</textarea>
                @error('description')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-lg border-t border-outline-variant flex flex-col md:flex-row items-center justify-between gap-md">
                <div class="flex items-start gap-xs text-on-surface-variant font-body-sm">
                    <span class="material-symbols-outlined text-secondary">info</span>
                    <p class="max-w-md">Modifying auction parameters will update the live listing immediately for all active bidders.</p>
                </div>
                <div class="flex gap-md w-full md:w-auto">
                    <a href="{{ route('auctions.show', $auction->id) }}" class="flex-1 md:flex-none text-center bg-transparent border border-outline-variant text-on-surface px-xl py-sm rounded-lg font-label-md hover:bg-surface-container transition-all">
                        Cancel
                    </a>
                    <button type="submit" class="flex-1 md:flex-none text-center bg-primary text-on-primary px-xl py-sm rounded-lg font-label-md font-bold hover:brightness-110 active:scale-95 transition-all">
                        Save Changes
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
