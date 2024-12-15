<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileUploader
{
    public function upload($file, $path)
    {
        if ($file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs($path, $fileName, 'public');
            return $filePath;
        }

        return null;
    }
}