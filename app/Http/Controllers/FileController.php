<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function store(Request $request){
        $path =  Storage::disk('public')->put('files', $request->file);
        return response()->json([
            'path' => $path,
            'uuid' => $request->uuid,
            'extension' => $request->file->getClientOriginalExtension()
        ], 200);
    }

    public function delete(Request $request){
        Storage::disk('public')->delete($request->path);
        return response()->json([
            'success' => true
        ], 200);
    }
}
