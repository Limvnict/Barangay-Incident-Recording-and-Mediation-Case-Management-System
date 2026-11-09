<?php
namespace App\Http\Controllers\Official;
use App\Http\Controllers\Controller;
use App\Models\Incident;

class DocumentController extends Controller {
    // $type is: summons, notice or settlement
    public function show(Incident $incident, string $type) {
        abort_unless(in_array($type, ['summons', 'notice', 'settlement']), 404);
        $incident->load('hearings');
        return view('official.document', ['incident' => $incident, 'type' => $type, 'hearing' => $incident->hearings->last()]);
    }
}
