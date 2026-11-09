<?php

namespace App\Http\Controllers\Official;

use App\Http\Controllers\Controller;
use App\Models\Hearing;
use App\Models\Incident;
use App\Models\Notice;
use Illuminate\Http\Request;

class HearingController extends Controller
{
    // Validation rules
    private function rules(): array
    {
        return [
            'stage' => 'required|in:' . implode(',', Hearing::STAGES),
            'hearing_date' => 'required|date',
            'outcome' => 'required|in:' . implode(',', Hearing::OUTCOMES),
            'service_status' => 'required|in:' . implode(',', Hearing::SERVICE),
            'served_by' => 'nullable|string|max:255',
            'served_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ];
    }

    // Save a new hearing
    public function store(Request $request, Incident $incident)
    {
        $data = $request->validate($this->rules());

        $hearing = $incident->hearings()->create($data);

        if ($incident->status == 'Filed') {
            $incident->update([
                'status' => 'Under Mediation'
            ]);
        }

        if ($hearing->outcome == 'Settled') {
            $incident->update([
                'status' => 'Settled'
            ]);
        }

        $message = $incident->blotter_no . ': '
            . $hearing->stage . ' on '
            . $hearing->hearing_date->format('M d, Y g:i A') . '.';

        Notice::send($incident, $message, true);

        return back()->with('success', 'Hearing saved. Resident was notified.');
    }

    // Show hearing edit page
    public function edit(Hearing $hearing)
    {
        return view('official.hearing-edit', compact('hearing'));
    }

    // Update an existing hearing
    public function update(Request $request, Hearing $hearing)
    {
        $data = $request->validate($this->rules());

        $hearing->update($data);

        $incident = $hearing->incident;

        if ($hearing->outcome == 'Settled') {
            $incident->update([
                'status' => 'Settled'
            ]);
        }

        $message = $incident->blotter_no
            . ': hearing updated ('
            . $hearing->hearing_date->format('M d, Y g:i A')
            . ', ' . $hearing->outcome . ').';

        Notice::send($incident, $message, true);

        return redirect()
            ->route('official.cases.show', $incident)
            ->with('success', 'Hearing updated.');
    }

    // Delete a hearing
    public function destroy(Hearing $hearing)
    {
        $incident = $hearing->incident;

        $hearing->delete();

        $message = $incident->blotter_no
            . ': a scheduled hearing was cancelled.';

        Notice::send($incident, $message, true);

        return redirect()
            ->route('official.cases.show', $incident)
            ->with('success', 'Hearing deleted.');
    }
}
