<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Services\AuditLogger;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(10);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:info,important,success',
        ]);

        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'is_published' => true,
        ]);

        AuditLogger::log('Announcement Broadcast', "Published a new {$request->type} update: {$request->title}");

        return back()->with('success', 'Announcement broadcasted successfully to all members.');
    }

    public function toggle(Announcement $announcement)
    {
        $announcement->update(['is_published' => !$announcement->is_published]);
        
        $status = $announcement->is_published ? 'published' : 'hidden';
        AuditLogger::log('Announcement Update', "Set announcement status to {$status}: {$announcement->title}");

        return back()->with('success', "Announcement status updated to {$status}.");
    }

    public function destroy(Announcement $announcement)
    {
        $title = $announcement->title;
        $announcement->delete();

        AuditLogger::log('Announcement Deletion', "Deleted announcement: {$title}");

        return back()->with('success', 'Announcement deleted successfully.');
    }
}
