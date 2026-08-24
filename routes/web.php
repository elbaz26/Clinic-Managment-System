<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;

// التوجيه التلقائي
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// جميع المسارات التالية تتطلب تسجل دخول (auth)
Route::middleware(['auth'])->group(function () {

    // لوحة التحكم المتاحة لجميع الأدوار
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // مسارات خاصة بالأدمن والأطباء فقط (admin, doctor)
    Route::middleware(['role:admin,doctor'])->group(function () {
        Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');
    });

    // مسارات إدارة المرضى والأطباء خاصة بالأدمن فقط (admin)
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('patients', PatientController::class);
        Route::resource('doctors', DoctorController::class);
    });

    Route::get('/appointments/{appointment}/pdf', [\App\Http\Controllers\AppointmentController::class, 'downloadPdf'])->middleware('auth')->name('appointments.pdf');

    // إدارة المواعيد متاحة لجميع الأطراف
    Route::resource('appointments', AppointmentController::class);

    // REST API Endpoints (للاختبار والمناقشة)
    Route::prefix('api/v1')->group(function () {
    Route::get('/doctors', [\App\Http\Controllers\ApiController::class, 'doctors']);
    Route::get('/stats', [\App\Http\Controllers\ApiController::class, 'stats']);
    });

});