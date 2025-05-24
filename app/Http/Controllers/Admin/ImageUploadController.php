<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();

            // Store the file in the public disk under 'uploads' directory
            $path = $file->storeAs('uploads', $fileName, 'public');

            return response()->json([
                'url' => Storage::url($path)
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
