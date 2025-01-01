<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class FileUploadHelper
{
    /**
     * Handle single file upload
     *
     * @param UploadedFile $file
     * @param string $disk
     * @param string $directory
     * @return array|null
     */
    public static function uploadSingleFile(UploadedFile $file, string $disk = 'public', string $directory = 'uploads'): ?array
    {
        if (!$file->isValid()) {
            return null;
        }

        // Generate a unique file name and store the file
        $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        #$filePath = $file->storeAs($directory, $fileName, $disk);
        $filePath = Storage::disk($disk)->putFileAs($directory, $file, $fileName);

        if (!$filePath) {
            return null;
        }

        // Return file details
        return [
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $fileName,
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ];
    }

    /**
     * Handle multiple file uploads
     *
     * @param array $files
     * @param string $disk
     * @param string $directory
     * @return array
     */
    public static function uploadMultipleFiles(array $files, string $disk = 'public', string $directory = 'uploads'): array
    {
        $fileDetails = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile && $file->isValid()) {
                $fileDetails[] = self::uploadSingleFile($file, $disk, $directory);
            }
        }

        return $fileDetails;
    }
}
