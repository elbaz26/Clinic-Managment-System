@extends('layouts.app')

@section('title', 'لوحة التحكم - نظام العيادة')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-1">📊 لوحة التحكم والإحصائيات</h2>
            <p class="text-muted mb-0">نظرة عامة على نشاط العيادة والحجوزات اليومية</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('patients.create') }}" class="btn btn-primary btn-sm fw-bold">+ مريض جديد</a>
            <a href="{{ route('doctors.create') }}" class="btn btn-outline-primary btn-sm fw-bold">+ طبيب جديد</a>
            <a href="{{ route('appointments.create') }}" class="btn btn-success btn-sm fw-bold">+ حجز موعد</a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 bg-white border-start border-4 border-primary">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted font-weight-bold d-block mb-1 fs-6">إجمالي المرضى</span>
                        <h2 class="fw-bold mb-0 text-primary">{{ $totalPatients }}</h2>
                    </div>
                    <div class="rounded-circle bg-primary-subtle p-3 text-primary fs-3">👥</div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('patients.index') }}" class="text-decoration-none small text-primary fw-bold">عرض القائمة الكاملة ←</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 bg-white border-start border-4 border-info">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted font-weight-bold d-block mb-1 fs-6">إجمالي الأطباء</span>
                        <h2 class="fw-bold mb-0 text-info">{{ $totalDoctors }}</h2>
                    </div>
                    <div class="rounded-circle bg-info-subtle p-3 text-info fs-3">👨‍⚕️</div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('doctors.index') }}" class="text-decoration-none small text-info fw-bold">عرض القائمة الكاملة ←</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 bg-white border-start border-4 border-success">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted font-weight-bold d-block mb-1 fs-6">مواعيد اليوم</span>
                        <h2 class="fw-bold mb-0 text-success">{{ $todayAppointments }}</h2>
                    </div>
                    <div class="rounded-circle bg-success-subtle p-3 text-success fs-3">📅</div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('appointments.index') }}" class="text-decoration-none small text-success fw-bold">جدول اليوم ←</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 bg-white border-start border-4 border-warning">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted font-weight-bold d-block mb-1 fs-6">مواعيد معلقة</span>
                        <h2 class="fw-bold mb-0 text-warning">{{ $pendingAppointments }}</h2>
                    </div>
                    <div class="rounded-circle bg-warning-subtle p-3 text-warning fs-3">🟡</div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('appointments.index', ['status' => 'pending']) }}" class="text-decoration-none small text-warning fw-bold">المواعيد المعلقة ←</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold text-primary mb-0">📋 أحدث 5 حجوزات بالموقع</h5>
            <a href="{{ route('appointments.index') }}" class="btn btn-sm btn-outline-primary fw-bold">عرض كافة الحجوزات</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>المريض</th>
                            <th>الطبيب المعالج</th>
                            <th>التاريخ والوقت</th>
                            <th>الحالة</th>
                            <th>التفاصيل</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentAppointments as $appointment)
                            <tr>
                                <td>{{ $appointment->id }}</td>
                                <td class="fw-bold text-dark">{{ $appointment->patient?->user?->name ?? 'غير محدد' }}</td>
                                <td>
                                    <strong>{{ $appointment->doctor?->user?->name ?? 'غير محدد' }}</strong>
                                    <small class="text-muted d-block">({{ $appointment->doctor?->specialization ?? '-' }})</small>
                                </td>
                                <td>
                                    <span>{{ $appointment->appointment_date }}</span>
                                    <small class="text-muted d-block">{{ $appointment->appointment_time }}</small>
                                </td>
                                <td>
                                    @if($appointment->status === 'pending')
                                        <span class="badge bg-warning text-dark">معلق 🟡</span>
                                    @elseif($appointment->status === 'confirmed')
                                        <span class="badge bg-success">مؤكد 🟢</span>
                                    @elseif($appointment->status === 'completed')
                                        <span class="badge bg-primary">مكتمل 🔵</span>
                                    @else
                                        <span class="badge bg-danger">ملغي 🔴</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-light border text-primary fw-bold">عرض</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted py-4">لا توجد حجوزات مسجلة حتى الآن</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection