<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPatients       = Patient::count();
        $totalDoctors        = Doctor::count();
        $todayAppointments   = Appointment::whereDate('appointment_date', date('Y-m-d'))->count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();

        $recentAppointments = Appointment::with(['patient.user', 'doctor.user'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalPatients',
            'totalDoctors',
            'todayAppointments',
            'pendingAppointments',
            'recentAppointments'
        ));
    }
}