<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model {
    protected $guarded = [];
    public function incident() { return $this->belongsTo(Incident::class); }
}
