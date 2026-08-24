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
    Schema::create('patients', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ربط بجدول المستخدمين
        $table->string('phone'); // رقم التليفون
        $table->text('address')->nullable(); // العنوان
        $table->date('date_of_birth')->nullable(); // تاريخ الميلاد
        $table->enum('gender', ['male', 'female'])->default('male'); // النوع
        $table->string('blood_group')->nullable(); // فصيلة الدم
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
