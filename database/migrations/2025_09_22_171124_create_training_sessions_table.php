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
            
            // Foreign Keys
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->foreignId('trainer_id')->constrained()->onDelete('restrict');

            // Session Details
            $table->string('title')->nullable();
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->unsignedInteger('capacity');
            $table->string('location')->nullable();
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
