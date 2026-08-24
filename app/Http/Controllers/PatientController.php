<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    /**
     * عرض قائمة كل المرضى
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $patients = Patient::with('user')
            ->when($search, function ($query, $search) {
                $query->where('phone', 'LIKE', "%{$search}%")
                      ->orWhereHas('user', function ($q) use ($search) {
                          $q->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('email', 'LIKE', "%{$search}%");
                      });
            })
            ->latest()
            ->paginate(10);

        return view('patients.index', compact('patients', 'search'));
    }

    /**
     * عرض فورم إضافة مريض جديد
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * حفظ المريض الجديد مع رفع الصورة
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'phone'         => 'required|string|max:20',
            'address'       => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender'        => 'required|in:male,female',
            'blood_group'   => 'nullable|string|max:5',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB كحد أقصى
        ]);

        // معالجة رفع الصورة إن وجدت
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('users', 'public');
        }

        // 1. إنشاء حساب المستخدم
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make('12345678'),
            'role'     => 'patient',
            'image'    => $imagePath,
        ]);

        // 2. إنشاء ملف المريض
        Patient::create([
            'user_id'       => $user->id,
            'phone'         => $validated['phone'],
            'address'       => $validated['address'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'gender'        => $validated['gender'],
            'blood_group'   => $validated['blood_group'] ?? null,
        ]);

        return redirect()->route('patients.index')
                         ->with('success', 'تم إضافة المريض وسحب الصورة بنجاح ✅');
    }

    /**
     * عرض تفاصيل المريض
     */
    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    /**
     * عرض فورم التعديل
     */
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    /**
     * تحديث بيانات المريض والصورة
     */
    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $patient->user_id,
            'phone'         => 'required|string|max:20',
            'address'       => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender'        => 'required|in:male,female',
            'blood_group'   => 'nullable|string|max:5',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // معالجة تحديث الصورة
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إن وجدت
            if ($patient->user->image && Storage::disk('public')->exists($patient->user->image)) {
                Storage::disk('public')->delete($patient->user->image);
            }
            // رفع الصورة الجديدة
            $patient->user->image = $request->file('image')->store('users', 'public');
        }

        // تحديث بيانات المستخدم
        $patient->user->name  = $validated['name'];
        $patient->user->email = $validated['email'];
        $patient->user->save();

        // تحديث بيانات المريض
        $patient->update([
            'phone'         => $validated['phone'],
            'address'       => $validated['address'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'gender'        => $validated['gender'],
            'blood_group'   => $validated['blood_group'] ?? null,
        ]);

        return redirect()->route('patients.index')
                         ->with('success', 'تم تحديث بيانات وصورة المريض بنجاح ✏️');
    }

    /**
     * حذف المريض وصورته
     */
    public function destroy(Patient $patient)
    {
        // حذف الصورة من القرص إن وجدت
        if ($patient->user->image && Storage::disk('public')->exists($patient->user->image)) {
            Storage::disk('public')->delete($patient->user->image);
        }

        $patient->user->delete();

        return redirect()->route('patients.index')
                         ->with('success', 'تم حذف المريض وصورته بنجاح 🗑️');
    }
}