@extends('layouts.app')

@section('title', 'تفاصيل الطبيب - نظام العيادة')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-1">👨‍⚕️ تفاصيل الطبيب: {{ $doctor->user?->name }}</h2>
            <p class="text-muted mb-0">عرض بيانات التخصص والعيادة والحساب الشخصي</p>
        </div>
        <div>
            <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-warning btn-sm fw-bold me-2">✏️ تعديل</a>
            <a href="{{ route('doctors.index') }}" class="btn btn-outline-secondary btn-sm fw-bold">← العودة للقائمة</a>
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
                            <span class="text-muted">اسم الطبيب:</span>
                            <strong>{{ $doctor->user?->name ?? '-' }}</strong>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">البريد الإلكتروني:</span>
                            <span>{{ $doctor->user?->email ?? '-' }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">رقم التليفون:</span>
                            <span>{{ $doctor->phone }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white pt-3 border-0">
                    <h5 class="fw-bold text-primary m-0">🏥 بيانات العيادة</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush fs-6">
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">التخصص:</span>
                            <span class="badge bg-info text-dark fs-6">{{ $doctor->specialization }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">رقم الغرفة:</span>
                            <span>{{ $doctor->room_number ?? 'غير محدد' }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">تاريخ التسجيل:</span>
                            <span>{{ $doctor->created_at ? $doctor->created_at->format('Y-m-d') : '-' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection