<?php

namespace App\Http\Controllers\Official;

use App\Http\Controllers\Controller;
use App\Models\{Hearing, Incident, Notice, SmsLog};
use Illuminate\Http\Request;

class CaseController extends Controller
{
    public function index(Request $r)
    {
        $q = Incident::latest();

        if ($r->filled('status')) {
            $q->where('status', $r->status);
        }

        if ($r->filled('search')) {
            $s = '%' . $r->search . '%';

            $q->where(function ($w) use ($s) {
                $w->where('blotter_no', 'like', $s)
                    ->orWhere('complainant_name', 'like', $s)
                    ->orWhere('respondent_name', 'like', $s);
            });
        }

        $counts = Incident::selectRaw('status, count(*) as c')
            ->groupBy('status')
            ->pluck('c', 'status');

        // Dashboard stats
        $totalCases = Incident::count();

        $thisMonth = Incident::whereMonth('incident_date', now()->month)
            ->whereYear('incident_date', now()->year)
            ->count();

        $todayCases = Incident::whereDate('incident_date', today())->count();

        $mostCommon = Incident::selectRaw('incident_type, count(*) as total')
            ->groupBy('incident_type')
            ->orderByDesc('total')
            ->first();

        return view('official.index', [
            'incidents' => $q->paginate(10)->withQueryString(),
            'counts' => $counts,
            'totalCases' => $totalCases,
            'thisMonth' => $thisMonth,
            'todayCases' => $todayCases,
            'mostCommon' => $mostCommon,
        ]);
    }

    public function show(Incident $incident)
    {
        // How many other cases has this respondent been involved in?
        $others = Incident::where('respondent_name', $incident->respondent_name)
            ->where('id', '!=', $incident->id)
            ->count();

        return view('official.show', [
            'incident' => $incident->load('hearings'),
            'others' => $others,
        ]);
    }

    public function edit(Incident $incident)
    {
        return view('official.edit', compact('incident'));
    }

    public function update(Request $r, Incident $incident)
    {
        $data = $r->validate([
            'complainant_name' => 'required|string|max:255',
            'respondent_name' => 'required|string|max:255',
            'respondent_contact' => ['nullable', 'regex:/^09[0-9]{9}$/'],
            'incident_type' => 'required|in:' . implode(',', Incident::TYPES),
            'incident_date' => 'required|date',
            'location' => 'required|string|max:255',
            'narrative' => 'required|string|min:10',
        ]);

        $incident->update($data);

        Notice::send(
            $incident,
            $incident->blotter_no . ': the barangay updated your complaint details.'
        );

        return redirect()
            ->route('official.cases.show', $incident)
            ->with('success', 'Complaint updated.');
    }

    public function destroy(Incident $incident)
    {
        $incident->delete();

        return redirect()
            ->route('official.dashboard')
            ->with('success', 'Complaint deleted.');
    }

    public function updateStatus(Request $r, Incident $incident)
    {
        $r->validate([
            'status' => 'required|in:' . implode(',', Incident::STATUSES),
        ]);

        $incident->update(['status' => $r->status]);

        Notice::send(
            $incident,
            $incident->blotter_no . ': status changed to ' . $r->status . '.'
        );

        return back()->with('success', 'Status updated. Resident was notified.');
    }

    // All upcoming hearings
    public function calendar()
    {
        $hearings = Hearing::with('incident')
            ->where('hearing_date', '>=', now()->startOfDay())
            ->orderBy('hearing_date')
            ->get();

        return view('calendar', [
            'hearings' => $hearings,
            'isOfficial' => true,
        ]);
    }

    public function sms()
    {
        return view('official.sms', [
            'logs' => SmsLog::with('incident')->latest()->paginate(15),
        ]);
    }
}