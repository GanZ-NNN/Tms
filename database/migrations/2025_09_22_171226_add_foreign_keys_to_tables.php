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
        Schema::table('programs', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('owner_id')->nullable()->constrained('users')->onDelete('set null');
        });

        Schema::table('sessions', function (Blueprint $table) {
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->foreignId('trainer_id')->constrained()->onDelete('restrict');
        });

        // ... ทำแบบนี้กับตารางอื่นๆ (registrations, attendances, etc.) ...
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            //
        });
    }
};
