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
    Schema::create('appointments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade'); // ربط بالطبيب
        $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade'); // ربط بالمريض
        $table->date('appointment_date'); // تاريخ الموعد
        $table->time('appointment_time'); // وقت الموعد
        $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending'); // حالة الموعد
        $table->text('notes')->nullable(); // ملاحظات
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
