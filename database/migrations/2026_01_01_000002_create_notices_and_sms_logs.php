<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // in-app notifications (the bell + pop-up)
        Schema::create('notices', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('incident_id')->nullable()->constrained()->cascadeOnDelete();
            $t->string('message');
            $t->timestamp('read_at')->nullable();
            $t->timestamps();
        });
        // simulated SMS: saved here instead of really sending
        Schema::create('sms_logs', function (Blueprint $t) {
            $t->id();
            $t->foreignId('incident_id')->nullable()->constrained()->cascadeOnDelete();
            $t->string('to_number');
            $t->string('message');
            $t->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('sms_logs');
        Schema::dropIfExists('notices');
    }
};
