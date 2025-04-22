<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\String_;

trait FileTraits
{

    public function uploadFile(Request $request, $filename, $path)
    {

        if ($request->hasFile($filename)) {
            $file = $request->file($filename);
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            return $file->storeAs($path, $filename, 'public');

        }

        return null;

    }


    public function deleteFile($path)
    {

        if ($path && Storage::disk('public')->exists($path)) {

            return Storage::disk('public')->delete($path);
        }
        return null;
    }

}
