@extends('layouts.app')

@section('title', 'تفاصيل الموعد - نظام العيادة')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-1">📄 تفاصيل الحجز رقم #{{ $appointment->id }}</h2>
            <p class="text-muted mb-0">عرض كافة معلومات المريض والطبيب والملاحظات الطبية</p>
        </div>
        <div>
            <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-warning btn-sm fw-bold me-2">✏️ تعديل</a>
            <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary btn-sm fw-bold">← العودة للقائمة</a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white pt-3 border-0">
                    <h5 class="fw-bold text-primary m-0">👤 بيانات المريض</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush fs-6">
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">اسم المريض:</span>
                            <strong>{{ $appointment->patient?->user?->name ?? 'غير محدد' }}</strong>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">تليفون المريض:</span>
                            <span>{{ $appointment->patient?->phone ?? '-' }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">فصيلة الدم:</span>
                            <span class="badge bg-danger fs-6">{{ $appointment->patient?->blood_group ?? 'غير محدد' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white pt-3 border-0">
                    <h5 class="fw-bold text-primary m-0">👨‍⚕️ بيانات الطبيب والموعد</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush fs-6">
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">اسم الطبيب:</span>
                            <strong>{{ $appointment->doctor?->user?->name ?? 'غير محدد' }}</strong>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">التخصص:</span>
                            <span class="badge bg-info text-dark fs-6">{{ $appointment->doctor?->specialization ?? '-' }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">تاريخ الموعد:</span>
                            <strong>{{ $appointment->appointment_date }}</strong>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">وقت الموعد:</span>
                            <strong>{{ $appointment->appointment_time }}</strong>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">حالة الموعد:</span>
                            @if($appointment->status === 'pending')
                                <span class="badge bg-warning text-dark fs-6">معلق 🟡</span>
                            @elseif($appointment->status === 'confirmed')
                                <span class="badge bg-success fs-6">مؤكد 🟢</span>
                            @elseif($appointment->status === 'completed')
                                <span class="badge bg-primary fs-6">مكتمل 🔵</span>
                            @else
                                <span class="badge bg-danger fs-6">ملغي 🔴</span>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white pt-3 border-0">
                    <h5 class="fw-bold text-primary m-0">📝 الملاحظات الطبية</h5>
                </div>
                <div class="card-body">
                    <p class="fs-6 m-0 text-muted">{{ $appointment->notes ?? 'لا توجد ملاحظات مسجلة لهذا الحجز.' }}</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection