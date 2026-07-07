<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Services\MediaService;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function __construct(protected MediaService $media)
    {
    }

    public function index(Request $request)
    {
        $folders = Media::select('folder')->distinct()->orderBy('folder')->pluck('folder');

        $items = Media::query()
            ->when($request->filled('folder'), fn ($q) => $q->where('folder', $request->string('folder')))
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', '%'.$request->string('search').'%'))
            ->latest()
            ->paginate(24)
            ->withQueryString();

        return view('admin.media.index', compact('items', 'folders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'files' => ['required', 'array', 'max:20'],
            'files.*' => ['image', 'mimes:jpeg,png,webp,svg,gif', 'max:8192'],
            'folder' => ['nullable', 'string', 'max:80'],
        ]);

        $folder = $request->input('folder') ?: 'general';
        foreach ($request->file('files') as $file) {
            $this->media->store($file, $folder);
        }

        if ($request->expectsJson()) {
            return response()->json(['ok' => true]);
        }

        return back()->with('success', count($request->file('files')).' file(s) uploaded.');
    }

    public function update(Request $request, Media $medium)
    {
        $request->validate([
            'alt' => ['nullable', 'string', 'max:255'],
            'file' => ['nullable', 'image', 'mimes:jpeg,png,webp,svg,gif', 'max:8192'],
        ]);

        if ($request->hasFile('file')) {
            $this->media->replace($medium, $request->file('file'));
        }

        $medium->update(['alt' => $request->input('alt', $medium->alt)]);

        return back()->with('success', 'Media updated.');
    }

    public function destroy(Media $medium)
    {
        $this->media->delete($medium);

        return back()->with('success', 'Media deleted.');
    }
}
