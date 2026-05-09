<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Services\AuditLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $images = Gallery::with('user')->latest()->paginate(24);
        return view('gallery.index', compact('images'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'    => 'required|string|max:255',
            'images'   => 'required|array|min:1|max:10',
            'images.*' => 'required|file|image|mimes:jpg,jpeg,png,webp,gif|max:20480',
        ]);

        $count = 0;
        $errors = [];

        foreach ($request->file('images', []) as $image) {
            try {
                // Store on the default disk (local, public, or s3/R2)
                $path = $image->store('gallery');

                if (!$path) {
                    $errors[] = "Failed to store image: " . $image->getClientOriginalName();
                    continue;
                }

                Gallery::create([
                    'title'        => $validated['title'],
                    'image_path'   => $path,
                    'is_published' => true,
                    'user_id'      => Auth::id(),
                ]);

                $count++;
            } catch (\Throwable $e) {
                Log::error('Gallery upload error: ' . $e->getMessage());
                $errors[] = "Error uploading " . $image->getClientOriginalName() . ": " . $e->getMessage();
            }
        }

        if ($count > 0) {
            AuditLogger::log('Gallery Contribution', Auth::user()->name . " uploaded {$count} image(s): '{$validated['title']}'");
        }

        if (!empty($errors)) {
            return back()
                ->with('warning', implode(' | ', $errors))
                ->with('success', $count > 0 ? "{$count} image(s) uploaded successfully." : null);
        }

        return back()->with('success', "Thank you! {$count} image(s) added to our shared memories.");
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->user_id !== Auth::id() && !Auth::user()->hasAnyRole(['Super Admin', 'Election Admin', 'Finance Admin'])) {
            abort(403);
        }

        Storage::disk(config('filesystems.default'))->delete($gallery->image_path);
        $title = $gallery->title;
        $gallery->delete();

        AuditLogger::log('Gallery Deletion', Auth::user()->name . " removed an image: {$title}");

        return back()->with('success', 'Memory removed from gallery.');
    }
}
