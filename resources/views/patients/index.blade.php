@extends('layouts.app')

@section('title', 'إدارة المرضى - نظام العيادة')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-1">👥 إدارة المرضى</h2>
            <p class="text-muted mb-0">عرض كافة المرضى المسجلين وإدارة بياناتهم وصورهم</p>
        </div>
        <a href="{{ route('patients.create') }}" class="btn btn-success fw-bold">+ إضافة مريض جديد</a>
    </div>

    <!-- شريط البحث -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('patients.index') }}" class="row g-2">
                <div class="col-md-10">
                    <input type="text" name="search" class="form-control" placeholder="ابحث باسم المريض، الإيميل، أو رقم التليفون..." value="{{ $search ?? '' }}">
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary fw-bold">بحث 🔍</button>
                </div>
            </form>
        </div>
    </div>

    <!-- جدول المرضى -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>الصورة</th>
                            <th>الاسم</th>
                            <th>الإيميل</th>
                            <th>التليفون</th>
                            <th>النوع</th>
                            <th>فصيلة الدم</th>
                            <th>التحكم</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patients as $patient)
                            <tr>
                                <td>{{ $patient->id }}</td>
                                <td>
                                    @if($patient->user?->image)
                                        <img src="{{ asset('storage/' . $patient->user->image) }}" alt="الصورة" class="rounded-circle object-fit-cover border" width="45" height="45">
                                    @else
                                        <div class="rounded-circle bg-light border text-muted d-inline-flex align-items-center justify-content-between p-2 fs-5" style="width: 45px; height: 45px;">👤</div>
                                    @endif
                                </td>
                                <td class="fw-bold text-dark">{{ $patient->user?->name ?? 'غير محدد' }}</td>
                                <td>{{ $patient->user?->email ?? '-' }}</td>
                                <td>{{ $patient->phone }}</td>
                                <td>
                                    @if($patient->gender === 'male')
                                        <span class="badge bg-primary-subtle text-primary">ذكر 👨</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger">أنثى 👩</span>
                                    @endif
                                </td>
                                <td><span class="badge bg-danger fs-6">{{ $patient->blood_group ?? '-' }}</span></td>
                                <td>
                                    <a href="{{ route('patients.show', $patient) }}" class="btn btn-sm btn-info text-white">عرض</a>
                                    <a href="{{ route('patients.edit', $patient) }}" class="btn btn-sm btn-warning">تعديل</a>
                                    <form action="{{ route('patients.destroy', $patient) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المريض؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-muted py-4">لا يوجد مرضى مسجلين حالياً</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3">
                {{ $patients->withQueryString()->links() }}
            </div>
        </div>
    </div>

</div>
@endsection