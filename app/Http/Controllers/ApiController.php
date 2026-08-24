<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * API بيرجع قائمة الأطباء بصيغة JSON
     */
    public function doctors()
    {
        $doctors = Doctor::with('user:id,name,email')->get();

        return response()->json([
            'status'  => true,
            'message' => 'Doctors list retrieved successfully',
            'data'    => $doctors
        ], 200);
    }

    /**
     * API بيرجع إحصائيات العيادة بصيغة JSON
     */
    public function stats()
    {
        return response()->json([
            'status' => true,
            'message' => 'Clinic statistics retrieved successfully',
            'data'   => [
                'total_patients'       => Patient::count(),
                'total_doctors'        => Doctor::count(),
                'today_appointments'   => Appointment::whereDate('appointment_date', date('Y-m-d'))->count(),
                'pending_appointments' => Appointment::where('status', 'pending')->count(),
            ]
        ], 200);
    }
}