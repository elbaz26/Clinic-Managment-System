@extends('layouts.app')

@section('title', 'إدارة الأطباء - نظام العيادة')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-1">👨‍⚕️ إدارة الأطباء</h2>
            <p class="text-muted mb-0">عرض كافة الأطباء المسجلين وتخصصاتهم وغرف العيادة</p>
        </div>
        <a href="{{ route('doctors.create') }}" class="btn btn-success fw-bold">+ إضافة طبيب جديد</a>
    </div>

    <!-- شريط البحث -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('doctors.index') }}" class="row g-2">
                <div class="col-md-10">
                    <input type="text" name="search" class="form-control" placeholder="ابحث باسم الطبيب، التخصص، أو رقم التليفون..." value="{{ $search ?? '' }}">
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary fw-bold">بحث 🔍</button>
                </div>
            </form>
        </div>
    </div>

    <!-- جدول الأطباء -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>الإيميل</th>
                            <th>التخصص</th>
                            <th>التليفون</th>
                            <th>رقم الغرفة</th>
                            <th>التحكم</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($doctors as $doctor)
                            <tr>
                                <td>{{ $doctor->id }}</td>
                                <td class="fw-bold text-dark">{{ $doctor->user?->name ?? 'غير محدد' }}</td>
                                <td>{{ $doctor->user?->email ?? '-' }}</td>
                                <td><span class="badge bg-info-subtle text-info fw-bold fs-6">{{ $doctor->specialization }}</span></td>
                                <td>{{ $doctor->phone }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $doctor->room_number ?? 'غير محدد' }}</span></td>
                                <td>
                                    <a href="{{ route('doctors.show', $doctor) }}" class="btn btn-sm btn-info text-white">عرض</a>
                                    <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-sm btn-warning">تعديل</a>
                                    <form action="{{ route('doctors.destroy', $doctor) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطبيب؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted py-4">لا يوجد أطباء مسجلين حالياً</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3">
                {{ $doctors->withQueryString()->links() }}
            </div>
        </div>
    </div>

</div>
@endsection