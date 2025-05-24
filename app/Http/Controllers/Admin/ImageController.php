<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $path = $file->store('public/uploads');
            $url  = Storage::url($path);
            return response()->json([
                'url' => $url
            ]);
        }
        return response()->json(['error' => 'No file uploaded.'], 400);
    }
}
