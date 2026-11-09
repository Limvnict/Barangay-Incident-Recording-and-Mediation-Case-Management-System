<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Hearing extends Model {
    public const STAGES = ['Punong Barangay Mediation', 'Pangkat ng Tagapagkasundo Conciliation'];
    public const OUTCOMES = ['Scheduled', 'Settled', 'Failed', 'Postponed'];
    public const SERVICE = ['Not yet served', 'Served', 'Refused', 'Not found'];
    protected $guarded = [];
    protected $casts = ['hearing_date' => 'datetime', 'served_date' => 'date'];
    public function incident() { return $this->belongsTo(Incident::class); }
}
