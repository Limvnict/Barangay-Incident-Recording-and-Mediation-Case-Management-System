<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('incidents', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete(); // resident who filed it
            $t->string('blotter_no')->unique();
            $t->string('complainant_name');
            $t->string('respondent_name');
            $t->string('respondent_contact')->nullable();
            $t->string('incident_type');
            $t->date('incident_date');
            $t->string('location');
            $t->text('narrative');
            $t->string('status')->default('Filed');
            $t->timestamps();
        });
        Schema::create('hearings', function (Blueprint $t) {
            $t->id();
            $t->foreignId('incident_id')->constrained()->cascadeOnDelete();
            $t->string('stage');
            $t->dateTime('hearing_date');
            $t->string('outcome')->default('Scheduled');
            $t->string('service_status')->default('Not yet served'); // was the summons delivered?
            $t->string('served_by')->nullable();
            $t->date('served_date')->nullable();
            $t->text('notes')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('hearings');
        Schema::dropIfExists('incidents');
    }
};
