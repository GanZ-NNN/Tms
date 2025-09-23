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
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // *** แก้ไขชื่อตารางตรงนี้ด้วย ***
        Schema::dropIfExists('training_sessions');
    }
};
