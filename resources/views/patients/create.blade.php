@extends('layouts.app')

@section('title', 'إضافة مريض جديد - نظام العيادة')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-1">➕ إضافة مريض جديد</h2>
            <p class="text-muted mb-0">إدخال البيانات الشخصية والطبية والصورة الشخصية</p>
        </div>
        <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary btn-sm fw-bold">← العودة للقائمة</a>
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
            <!-- ⚠️ إضافة enctype مهمة جداً لرفع الصور -->
            <form action="{{ route('patients.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="name" class="form-label font-weight-bold">اسم المريض <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="أدخل الاسم الثلاثي" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label font-weight-bold">البريد الإلكتروني <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="patient@example.com" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label font-weight-bold">رقم التليفون <span class="text-danger">*</span></label>
                        <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="01xxxxxxxxx" required>
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="gender" class="form-label font-weight-bold">النوع <span class="text-danger">*</span></label>
                        <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror" required>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>ذكر</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>أنثى</option>
                        </select>
                        @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="date_of_birth" class="form-label font-weight-bold">تاريخ الميلاد</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth') }}">
                        @error('date_of_birth') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="blood_group" class="form-label font-weight-bold">فصيلة الدم</label>
                        <select name="blood_group" id="blood_group" class="form-select @error('blood_group') is-invalid @enderror">
                            <option value="">-- اختار فصيلة الدم --</option>
                            @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $bg)
                                <option value="{{ $bg }}" {{ old('blood_group') == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                            @endforeach
                        </select>
                        @error('blood_group') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- حقل رفع الصورة الشخصية -->
                    <div class="col-md-4">
                        <label for="image" class="form-label font-weight-bold">الصورة الشخصية (اختياري)</label>
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12">
                        <label for="address" class="form-label font-weight-bold">العنوان</label>
                        <textarea name="address" id="address" rows="3" class="form-control @error('address') is-invalid @enderror" placeholder="أدخل عنوان المريض التفصيلي">{{ old('address') }}</textarea>
                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary px-4 fw-bold">💾 حفظ البيانات</button>
                    <a href="{{ route('patients.index') }}" class="btn btn-secondary px-4 me-2">إلغاء</a>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection