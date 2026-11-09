<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model {
    protected $guarded = [];
    protected $casts = ['read_at' => 'datetime'];
    public function incident() { return $this->belongsTo(Incident::class); }

    public static function send(Incident $incident, string $message, bool $toRespondent = false): void
    {
        self::create(['user_id' => $incident->user_id, 'incident_id' => $incident->id, 'message' => $message]);

        if ($incident->user->phone) {
            SmsLog::create(['incident_id' => $incident->id, 'to_number' => $incident->user->phone, 'message' => $message]);
        }
        if ($toRespondent && $incident->respondent_contact) {
            SmsLog::create(['incident_id' => $incident->id, 'to_number' => $incident->respondent_contact, 'message' => $message]);
        }
    }
}
