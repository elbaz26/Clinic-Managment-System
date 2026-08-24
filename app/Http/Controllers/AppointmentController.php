<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $appointments = Appointment::with(['doctor.user', 'patient.user'])
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()->paginate(10);

        return view('appointments.index', compact('appointments', 'status'));
    }

    public function create()
    {
        $doctors = Doctor::with('user')->get();
        $patients = Patient::with('user')->get();
        return view('appointments.create', compact('doctors', 'patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id'        => 'required|exists:doctors,id',
            'patient_id'       => 'required|exists:patients,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'notes'            => 'nullable|string',
        ]);

        Appointment::create($validated + ['status' => 'pending']);

        return redirect()->route('appointments.index')->with('success', 'تم حجز الموعد بنجاح 📅');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['doctor.user', 'patient.user']);
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $doctors = Doctor::with('user')->get();
        $patients = Patient::with('user')->get();
        return view('appointments.edit', compact('appointment', 'doctors', 'patients'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'doctor_id'        => 'required|exists:doctors,id',
            'patient_id'       => 'required|exists:patients,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status'           => 'required|in:pending,confirmed,completed,cancelled',
            'notes'            => 'nullable|string',
        ]);

        $appointment->update($validated);
        return redirect()->route('appointments.index')->with('success', 'تم تحديث الموعد بنجاح ✏️');
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate(['status' => 'required|in:pending,confirmed,completed,cancelled']);
        $appointment->update(['status' => $validated['status']]);
        return redirect()->back()->with('success', 'تم تغيير حالة الموعد بنجاح 🔄');
    }

    public function downloadPdf(Appointment $appointment)
    {
        $appointment->load(['doctor.user', 'patient.user']);

        // استخدمنا مكتبة Pdf (DomPDF) اللي متسطبة عندك فعلياً
        $pdf = Pdf::loadView('appointments.pdf', compact('appointment'));

        return $pdf->download('appointment-ticket-' . $appointment->id . '.pdf');
    }
    
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'تم حذف الموعد بنجاح 🗑️');
    }
}