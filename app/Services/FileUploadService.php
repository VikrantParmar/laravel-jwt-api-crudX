<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\FileUploadHelper;

class FileUploadService
{
    /**
     * Handle image upload with dynamic file input name
     *
     * @param Request $request
     * @param string $type
     * @param string $inputName
     * @return string|null
     */
    public function handleImageUpload(Request $request, $inputName = 'image', $type = 'blog')
    {
        if ($request->hasFile($inputName)) {
            $image = $request->file($inputName);
            $uploadResult = FileUploadHelper::uploadSingleFile($image, $type, '');
            if ($uploadResult === null) {
                throw new \Exception(__('messages.file_upload_failed'));
            }
            return $uploadResult;//['file_path'];
        }
        return null;
    }

    /**
     * Handle image update with dynamic file input name
     *
     * @param Request $request
     * @param object $record
     * @param string $type
     * @param string $inputName
     * @return string
     */
    public function handleImageUpdate(Request $request, $inputName = 'image', $record, $type = 'blog')
    {
        $imageName = $record->$inputName;
        if ($request->hasFile($inputName)) {
            $image = $request->file($inputName);
            $uploadResult = FileUploadHelper::uploadSingleFile($image, $type, '');
            if ($uploadResult === null) {
                throw new \Exception(__('messages.file_upload_failed'));
            }
            // If the record has an existing image, delete it.
            if ($record->$inputName) {
                Storage::disk($type)->delete($record->image);
            }
            $imageName = $uploadResult;//['file_path'];
        }
        return $imageName;
    }
}
