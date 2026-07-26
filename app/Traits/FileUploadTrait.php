<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait FileUploadTrait
{

    public function uploadFile(UploadedFile $file, string $folder = 'auctions', string $disk = 'public'): string
    {
        return $file->store($folder, $disk);
    }

    public function deleteFile(?string $path, string $disk = 'public'): void
    {
        if ($path && Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->delete($path);
        }
    }
}
