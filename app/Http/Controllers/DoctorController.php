<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    /**
     * عرض قائمة الأطباء
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $doctors = Doctor::with('user')
            ->when($search, function ($query, $search) {
                $query->where('specialization', 'LIKE', "%{$search}%")
                      ->orWhere('phone', 'LIKE', "%{$search}%")
                      ->orWhereHas('user', function ($q) use ($search) {
                          $q->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('email', 'LIKE', "%{$search}%");
                      });
            })
            ->latest()
            ->paginate(10);

        return view('doctors.index', compact('doctors', 'search'));
    }

    /**
     * عرض فورم إضافة طبيب جديد
     */
    public function create()
    {
        return view('doctors.create');
    }

    /**
     * حفظ الطبيب الجديد
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email',
            'phone'          => 'required|string|max:20',
            'specialization' => 'required|string|max:255',
            'room_number'    => 'nullable|string|max:50',
        ]);

        // 1. إنشاء حساب مستخدم بـ role = doctor
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make('12345678'),
            'role'     => 'doctor',
        ]);

        // 2. إنشاء ملف الطبيب
        Doctor::create([
            'user_id'        => $user->id,
            'phone'          => $validated['phone'],
            'specialization' => $validated['specialization'],
            'room_number'    => $validated['room_number'] ?? null,
        ]);

        return redirect()->route('doctors.index')
                         ->with('success', 'تم إضافة الطبيب بنجاح 👨‍⚕️');
    }

    /**
     * عرض تفاصيل طبيب واحد
     */
    public function show(Doctor $doctor)
    {
        return view('doctors.show', compact('doctor'));
    }

    /**
     * عرض فورم تعديل بيانات الطبيب
     */
    public function edit(Doctor $doctor)
    {
        return view('doctors.edit', compact('doctor'));
    }

    /**
     * تحديث بيانات الطبيب
     */
    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email,' . $doctor->user_id,
            'phone'          => 'required|string|max:20',
            'specialization' => 'required|string|max:255',
            'room_number'    => 'nullable|string|max:50',
        ]);

        $doctor->user->update([
            'name'  => $validated['name'],
            'email' => $validated['email'],
        ]);

        $doctor->update([
            'phone'          => $validated['phone'],
            'specialization' => $validated['specialization'],
            'room_number'    => $validated['room_number'] ?? null,
        ]);

        return redirect()->route('doctors.index')
                         ->with('success', 'تم تحديث بيانات الطبيب بنجاح ✏️');
    }

    /**
     * حذف الطبيب
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->user->delete();

        return redirect()->route('doctors.index')
                         ->with('success', 'تم حذف الطبيب بنجاح 🗑️');
    }
}