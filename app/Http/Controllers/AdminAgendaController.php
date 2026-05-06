<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use App\Services\AuditLogger;

class AdminAgendaController extends Controller
{
    public function index()
    {
        $agendas = Agenda::orderBy('order')->get();
        return view('admin.agenda.index', compact('agendas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'time' => 'required|string',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'order' => 'required|integer',
        ]);

        Agenda::create($request->all());

        AuditLogger::log('Agenda Created', "Admin added a new agenda item: {$request->title}");

        return back()->with('success', 'Agenda item added successfully.');
    }

    public function update(Request $request, Agenda $agenda)
    {
        $request->validate([
            'time' => 'required|string',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'order' => 'required|integer',
        ]);

        $agenda->update($request->all());

        AuditLogger::log('Agenda Updated', "Admin updated agenda item: {$agenda->title}");

        return back()->with('success', 'Agenda item updated successfully.');
    }

    public function destroy(Agenda $agenda)
    {
        $title = $agenda->title;
        $agenda->delete();

        AuditLogger::log('Agenda Deleted', "Admin removed agenda item: {$title}");

        return back()->with('success', 'Agenda item removed.');
    }
}
