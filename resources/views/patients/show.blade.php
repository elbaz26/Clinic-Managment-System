@extends('layouts.app')

@section('title', 'تفاصيل المريض - نظام العيادة')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-1">👤 تفاصيل المريض: {{ $patient->user?->name }}</h2>
            <p class="text-muted mb-0">عرض كافة البيانات الشخصية والطبية وتاريخ التسجيل</p>
        </div>
        <div>
            <a href="{{ route('patients.edit', $patient) }}" class="btn btn-warning btn-sm fw-bold me-2">✏️ تعديل</a>
            <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary btn-sm fw-bold">← العودة للقائمة</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white pt-3 border-0">
                    <h5 class="fw-bold text-primary m-0">📌 البيانات الشخصية</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush fs-6">
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">الاسم بالكامل:</span>
                            <strong>{{ $patient->user?->name ?? '-' }}</strong>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">البريد الإلكتروني:</span>
                            <span>{{ $patient->user?->email ?? '-' }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">رقم التليفون:</span>
                            <span>{{ $patient->phone }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">النوع:</span>
                            <span>{{ $patient->gender === 'male' ? 'ذكر 👨' : 'أنثى 👩' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white pt-3 border-0">
                    <h5 class="fw-bold text-primary m-0">🏥 البيانات الطبية والعنوان</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush fs-6">
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">تاريخ الميلاد:</span>
                            <span>{{ $patient->date_of_birth ?? 'غير محدد' }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">فصيلة الدم:</span>
                            <span class="badge bg-danger fs-6">{{ $patient->blood_group ?? 'غير محدد' }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">تاريخ التسجيل:</span>
                            <span>{{ $patient->created_at ? $patient->created_at->format('Y-m-d') : '-' }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">العنوان:</span>
                            <span>{{ $patient->address ?? 'لا يوجد عنوان مدون' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection