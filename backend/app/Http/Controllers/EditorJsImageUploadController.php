<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Image\Image;

class EditorJsImageUploadController extends Controller
{
    public function file(Request $request): JsonResponse
    {
        $request->validate(['image' => 'required|image|max:10240']);

        $file = $request->file('image');
        $disk = config('moonshine-editor-js.toolSettings.image.disk', 'public');
        $path = config('moonshine-editor-js.toolSettings.image.path', 'images');

        $filename = Str::random(40) . '.webp';
        $storagePath = $path . '/' . $filename;
        $tmpPath = $file->getRealPath();

        // Convert to WebP using Imagick via Spatie Image
        $fullPath = Storage::disk($disk)->path($storagePath);
        Image::load($tmpPath)
            ->width(1200)
            ->optimize()
            ->format('webp')
            ->save($fullPath);

        return response()->json([
            'success' => 1,
            'file' => [
                'url' => Storage::disk($disk)->url($storagePath),
            ],
        ]);
    }
}
