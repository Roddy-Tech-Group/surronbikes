<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function index(): View
    {
        $mediaFiles = Media::latest()->paginate(24);
        return view('admin.media.index', compact('mediaFiles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'files' => ['required', 'array'],
            'files.*' => ['required', 'image', 'mimes:jpg,jpeg,png,svg,webp', 'max:5120'], // 5MB max
        ]);

        $uploaded = 0;

        foreach ($request->file('files') as $file) {
            $path = $file->store('media', 'public');
            
            Media::create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'disk' => 'public',
                'mime_type' => $file->getClientMimeType(),
                'size' => $file->getSize(),
            ]);
            
            $uploaded++;
        }

        return back()->with('success', "{$uploaded} file(s) successfully uploaded.");
    }

    public function destroy(Media $media): RedirectResponse
    {
        if (Storage::disk($media->disk)->exists($media->file_path)) {
            Storage::disk($media->disk)->delete($media->file_path);
        }
        
        $media->delete();
        
        return back()->with('success', 'File deleted successfully.');
    }
}
