<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait FileUploadTrait
{

    public function uploadFile(UploadedFile $file, string $folder = 'auctions', string $disk = 'public'): string
    {
        // إرسال الصورة مباشرة إلى سحابة Cloudinary عبر HTTP API
        $response = Http::asMultipart()->post("https://api.cloudinary.com/v1_1/" . env('CLOUDINARY_CLOUD_NAME') . "/image/upload", [
            [
                'name'     => 'file',
                'contents' => fopen($file->getRealPath(), 'r'),
                'filename' => $file->getClientOriginalName(),
            ],
            [
                'name'     => 'upload_preset',
                'contents' => env('CLOUDINARY_UPLOAD_PRESET'),
            ],
            [
                'name'     => 'folder',
                'contents' => $folder,
            ]
        ]);

        if ($response->successful()) {
            $responseData = $response->json();
            // إرجاع الرابط السحابي الآمن النهائي لتخزينه في قاعدة البيانات
            return $responseData['secure_url'];
        }

        // في حال حدوث خطأ أثناء الرفع
        Log::error('Cloudinary Upload Failed: ' . $response->body());
        throw new \Exception('Failed to upload file to Cloudinary.');
    }

    public function deleteFile(?string $path, string $disk = 'public'): void
    {
        if ($path && Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->delete($path);
        }
    }
}
