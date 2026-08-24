@extends('layouts.app')

@section('title', 'حجز موعد جديد - نظام العيادة')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-1">➕ حجز موعد جديد</h2>
            <p class="text-muted mb-0">ربط المريض بالطبيب وتحديد تاريخ ووقت الزيارة</p>
        </div>
        <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary btn-sm fw-bold">← العودة للقائمة</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('appointments.store') }}" method="POST">
                @csrf
                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="patient_id" class="form-label font-weight-bold">المريض <span class="text-danger">*</span></label>
                        <select name="patient_id" id="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required>
                            <option value="">-- اختار المريض --</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->user?->name ?? 'مريض بدون اسم' }} (تليفون: {{ $patient->phone }})
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="doctor_id" class="form-label font-weight-bold">الطبيب المعالج <span class="text-danger">*</span></label>
                        <select name="doctor_id" id="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror" required>
                            <option value="">-- اختار الطبيب --</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->user?->name ?? 'دكتور بدون اسم' }} - (تخصص: {{ $doctor->specialization }})
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="appointment_date" class="form-label font-weight-bold">تاريخ الموعد <span class="text-danger">*</span></label>
                        <input type="date" name="appointment_date" id="appointment_date" class="form-control @error('appointment_date') is-invalid @enderror" value="{{ old('appointment_date', date('Y-m-d')) }}" required>
                        @error('appointment_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="appointment_time" class="form-label font-weight-bold">وقت الموعد <span class="text-danger">*</span></label>
                        <input type="time" name="appointment_time" id="appointment_time" class="form-control @error('appointment_time') is-invalid @enderror" value="{{ old('appointment_time', '10:00') }}" required>
                        @error('appointment_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12">
                        <label for="notes" class="form-label font-weight-bold">ملاحظات / أعراض المريض</label>
                        <textarea name="notes" id="notes" rows="3" class="form-control @error('notes') is-invalid @enderror" placeholder="أدخل سبب الزيارة أو الملاحظات الطبية المبدئية">{{ old('notes') }}</textarea>
                        @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success px-4 fw-bold">📅 تأكيد الحجز</button>
                    <a href="{{ route('appointments.index') }}" class="btn btn-secondary px-4 me-2">إلغاء</a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection