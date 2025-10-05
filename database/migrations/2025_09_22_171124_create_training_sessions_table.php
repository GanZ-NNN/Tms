<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('training_sessions', function (Blueprint $table) { 
        $table->id();
        $table->foreignId('program_id')->constrained()->onDelete('cascade');
        $table->foreignId('trainer_id')->constrained('trainers')->onDelete('restrict');
        
        $table->unsignedInteger('session_number')->nullable();
        $table->string('location')->nullable();
        $table->string('level')->nullable(); // <-- แก้ไขแล้ว
        $table->unsignedInteger('capacity')->nullable();
        $table->string('status')->default('scheduled');
        
        $table->dateTime('start_at');
        $table->dateTime('end_at');
        $table->dateTime('registration_start_at')->nullable();
        $table->dateTime('registration_end_at')->nullable();

        $table->timestamps();
    });
}

    public function down(): void
    {
        // *** แก้ไขชื่อตารางตรงนี้ด้วย ***
        Schema::dropIfExists('training_sessions');
    }
};
