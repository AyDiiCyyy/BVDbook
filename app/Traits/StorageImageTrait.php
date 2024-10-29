<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait StorageImageTrait
{
    public static function storageTraitUpload($request, $fieldName, $folderName)
    {
        if ($request->hasFile($fieldName)) {
            $path = $request->file($fieldName)->store($folderName,'public');

            $dataUploadTrait = [
                'name' => $request->file($fieldName)->getClientOriginalName(),
                'path' => Storage::url($path),
            ];

            return $dataUploadTrait;
        }

        return null;
    }

    public static function storageTraitUploadMultiple($request, $fieldName, $folderName)
    {
        $dataUploadTrait = [];

        if ($request->hasFile($fieldName)) {
            foreach ($request->file($fieldName) as $file) {
                $path = $file->store($folderName, 'public');

                $dataUploadTrait[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => Storage::url($path),
                ];
            }
        }

        return !empty($dataUploadTrait) ? $dataUploadTrait : null;
    }
}
