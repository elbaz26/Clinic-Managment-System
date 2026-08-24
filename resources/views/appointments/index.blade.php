@extends('layouts.app')

@section('title', 'جدول المواعيد - نظام العيادة')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-1">📅 جدول المواعيد والحجوزات</h2>
            <p class="text-muted mb-0">عرض كافة الحجوزات، فلترة الحالات، وتصدير تذاكر PDF</p>
        </div>
        <a href="{{ route('appointments.create') }}" class="btn btn-success fw-bold">+ حجز موعد جديد</a>
    </div>

    <!-- أزرار الفلترة حسب الحالة -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body d-flex flex-wrap gap-2 align-items-center">
            <span class="fw-bold me-2 text-primary">تصفية المواعيد:</span>
            <a href="{{ route('appointments.index') }}" class="btn btn-sm {{ !$status ? 'btn-dark' : 'btn-outline-dark' }}">الكل</a>
            <a href="{{ route('appointments.index', ['status' => 'pending']) }}" class="btn btn-sm {{ $status === 'pending' ? 'btn-warning text-dark' : 'btn-outline-warning text-dark' }}">🟡 معلقة</a>
            <a href="{{ route('appointments.index', ['status' => 'confirmed']) }}" class="btn btn-sm {{ $status === 'confirmed' ? 'btn-success' : 'btn-outline-success' }}">🟢 مؤكدة</a>
            <a href="{{ route('appointments.index', ['status' => 'completed']) }}" class="btn btn-sm {{ $status === 'completed' ? 'btn-primary' : 'btn-outline-primary' }}">🔵 مكتملة</a>
            <a href="{{ route('appointments.index', ['status' => 'cancelled']) }}" class="btn btn-sm {{ $status === 'cancelled' ? 'btn-danger' : 'btn-outline-danger' }}">🔴 ملغية</a>
        </div>
    </div>

    <!-- جدول المواعيد -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>المريض</th>
                            <th>الطبيب المعالج</th>
                            <th>التاريخ والوقت</th>
                            <th>الحالة الحالية</th>
                            <th>تغيير سريع للحالة</th>
                            <th>التحكم والتصدير</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
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
                                    <form action="{{ route('appointments.updateStatus', $appointment) }}" method="POST" class="d-inline-flex gap-1">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="form-select form-select-sm">
                                            <option value="pending" {{ $appointment->status === 'pending' ? 'selected' : '' }}>معلق</option>
                                            <option value="confirmed" {{ $appointment->status === 'confirmed' ? 'selected' : '' }}>تأكيد</option>
                                            <option value="completed" {{ $appointment->status === 'completed' ? 'selected' : '' }}>اكتمال</option>
                                            <option value="cancelled" {{ $appointment->status === 'cancelled' ? 'selected' : '' }}>إلغاء</option>
                                        </select>
                                        <button type="submit" class="btn btn-secondary btn-sm">تطبيق</button>
                                    </form>
                                </td>
                                <td>
                                    <!-- 📄 زرار التصدير لـ PDF -->
                                    <a href="{{ route('appointments.pdf', $appointment) }}" class="btn btn-sm btn-secondary text-white me-1">📄 PDF</a>

                                    <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-info text-white">عرض</a>
                                    <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-sm btn-warning">تعديل</a>
                                    <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الموعد؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted py-4">لا توجد مواعيد مدونة حالياً</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3">
                {{ $appointments->withQueryString()->links() }}
            </div>
        </div>
    </div>

</div>
@endsection