<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    public const STATUSES = [
        'Filed',
        'Under Mediation',
        'Settled',
        'Certificate to File Action',
        'Referred to Court',
        'Dismissed'
    ];

    public const TYPES = [
        'Physical Injury',
        'Verbal Dispute',
        'Property Dispute',
        'Noise Complaint',
        'Theft',
        'Domestic Concern',
        'Other'
    ];

    protected $guarded = [];

    protected $casts = [
        'incident_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hearings()
    {
        return $this->hasMany(Hearing::class)->orderBy('hearing_date');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
