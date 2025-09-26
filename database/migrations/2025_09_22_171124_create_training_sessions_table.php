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
        // *** แก้ไขชื่อตารางตรงนี้ ***
        Schema::create('training_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->foreignId('trainer_id')->constrained('trainers')->onDelete('cascade');
            $table->unsignedInteger('session_number');
            $table->string('location')->nullable();
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->dateTime('registration_start_at');
            $table->dateTime('registration_end_at');
            $table->enum ('level', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->string('status')->default('scheduled');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // *** แก้ไขชื่อตารางตรงนี้ด้วย ***
        Schema::dropIfExists('training_sessions');
    }
};
