<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\Hearing;
use App\Models\Incident;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    // Resident Dashboard
    public function index(Request $r)
    {
        $user = $r->user();

        // Get only the logged-in resident's complaints
        $baseQuery = $user->incidents();

        // Search input
        $search = $r->input('search');

        // Total complaints
        $totalComplaints = (clone $baseQuery)->count();

        // Count complaints by status
        $statusCounts = (clone $baseQuery)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $statusLabels = Incident::STATUSES;

        $statusData = collect($statusLabels)
            ->map(function ($status) use ($statusCounts) {
                return (int) ($statusCounts[$status] ?? 0);
            })
            ->values()
            ->all();

        // Monthly complaint activity
        $monthlyLabels = [];
        $monthlyData = [];

        $startMonth = now()->subMonths(5)->startOfMonth();

        for ($i = 0; $i < 6; $i++) {
            $month = $startMonth->copy()->addMonths($i);

            $monthlyLabels[] = $month->format('M Y');

            $monthlyData[] = (clone $baseQuery)
                ->whereMonth('incident_date', $month->month)
                ->whereYear('incident_date', $month->year)
                ->count();
        }

        // Complaint history with blotter number search
        $incidentQuery = clone $baseQuery;

        if ($search) {
            $incidentQuery->where(
                'blotter_no',
                'like',
                '%' . $search . '%'
            );
        }

        $incidents = $incidentQuery
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Upcoming hearings for this resident only
        $upcomingHearings = Hearing::with('incident')
            ->whereHas('incident', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('hearing_date', '>=', now()->startOfDay())
            ->orderBy('hearing_date')
            ->take(5)
            ->get();

        // Recent notifications
        $recentNotices = $user->notices()
            ->latest()
            ->take(5)
            ->get();

        return view('resident.index', compact(
            'incidents',
            'totalComplaints',
            'statusCounts',
            'statusLabels',
            'statusData',
            'monthlyLabels',
            'monthlyData',
            'upcomingHearings',
            'recentNotices',
            'search'
        ));
    }

    // Show complaint form
    public function create()
    {
        return view('resident.create');
    }

    // Submit a complaint
    public function store(Request $r)
    {
        $data = $r->validate([
            'respondent_name' => 'required|string|max:255',
            'respondent_contact' => [
                'nullable',
                'regex:/^09[0-9]{9}$/'
            ],
            'incident_type' => 'required|in:' . implode(',', Incident::TYPES),
            'incident_date' => 'required|date|before_or_equal:today',
            'location' => 'required|string|max:255',
            'narrative' => 'required|string|min:10',
        ]);

        $data['user_id'] = $r->user()->id;
        $data['complainant_name'] = $r->user()->name;

        $data['blotter_no'] = sprintf(
            'BLT-%d-%04d',
            now()->year,
            (Incident::max('id') ?? 0) + 1
        );

        $incident = Incident::create($data);

        return redirect()
            ->route('resident.dashboard.show', $incident)
            ->with('success', 'Complaint submitted: ' . $incident->blotter_no);
    }

    // View one complaint
    public function show(Request $r, Incident $incident)
    {
        abort_unless(
            $incident->user_id === $r->user()->id,
            403,
            'This is not your complaint.'
        );

        return view('resident.show', [
            'incident' => $incident->load('hearings')
        ]);
    }

    // Resident mediation calendar
    public function calendar(Request $r)
    {
        $hearings = Hearing::with('incident')
            ->whereHas('incident', function ($query) use ($r) {
                $query->where('user_id', $r->user()->id);
            })
            ->where('hearing_date', '>=', now()->startOfDay())
            ->orderBy('hearing_date')
            ->get();

        return view('calendar', [
            'hearings' => $hearings,
            'isOfficial' => false,
        ]);
    }
}
