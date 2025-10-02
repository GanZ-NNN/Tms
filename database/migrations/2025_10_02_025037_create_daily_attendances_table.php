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
        Schema::create('daily_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained('registrations')->onDelete('cascade');
            $table->date('attendance_date');
            $table->boolean('is_present_am')->default(false); // เช็คชื่อช่วงเช้า
            $table->boolean('is_present_pm')->default(false); // เช็คชื่อช่วงบ่าย
            $table->timestamps();

            $table->unique(['registration_id', 'attendance_date']); // ป้องกันข้อมูลซ้ำ
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_attendances');
    }
};
