<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Services\AuditLogger;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    public function index()
    {
        $images = Gallery::with('user')->latest()->paginate(24);
        return view('gallery.index', compact('images'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'images' => 'required|array|max:10',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp,jfif|max:20480',
        ]);

        $count = 0;
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('gallery', 'public');
                
                Gallery::create([
                    'title' => $request->title,
                    'image_path' => $path,
                    'is_published' => true,
                    'user_id' => Auth::id(),
                ]);
                $count++;
            }
            
            $role = Auth::user()->hasAnyRole(['Super Admin', 'Election Admin', 'Finance Admin']) ? 'Admin' : 'Member';
            AuditLogger::log('Gallery Contribution', "{$role} (" . Auth::user()->name . ") uploaded {$count} images to the shared gallery: '{$request->title}'");
        }

        return back()->with('success', "Thank you! {$count} images added to our shared memories.");
    }

    public function destroy(Gallery $gallery)
    {
        // Only uploader or admin can delete
        if ($gallery->user_id !== Auth::id() && !Auth::user()->hasAnyRole(['Super Admin', 'Election Admin', 'Finance Admin'])) {
            abort(403);
        }

        \Storage::disk('public')->delete($gallery->image_path);
        $title = $gallery->title;
        $gallery->delete();

        AuditLogger::log('Gallery Deletion', Auth::user()->name . " removed an image from the gallery: {$title}");

        return back()->with('success', 'Memory removed from gallery.');
    }
}
