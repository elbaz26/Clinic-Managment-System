@extends('layouts.app')

@section('title', 'إضافة طبيب جديد - نظام العيادة')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-1">➕ إضافة طبيب جديد</h2>
            <p class="text-muted mb-0">إدخال بيانات الحساب والتخصص ورقم الغرفة</p>
        </div>
        <a href="{{ route('doctors.index') }}" class="btn btn-outline-secondary btn-sm fw-bold">← العودة للقائمة</a>
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
            <form action="{{ route('doctors.store') }}" method="POST">
                @csrf
                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="name" class="form-label font-weight-bold">اسم الطبيب <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="د. أحمد محمد" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label font-weight-bold">البريد الإلكتروني <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="doctor@example.com" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label font-weight-bold">رقم التليفون <span class="text-danger">*</span></label>
                        <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="01xxxxxxxxx" required>
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="specialization" class="form-label font-weight-bold">التخصص <span class="text-danger">*</span></label>
                        <input type="text" name="specialization" id="specialization" class="form-control @error('specialization') is-invalid @enderror" value="{{ old('specialization') }}" placeholder="مثال: باطنة، أطفال، قلب..." required>
                        @error('specialization') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="room_number" class="form-label font-weight-bold">رقم الغرفة / العيادة</label>
                        <input type="text" name="room_number" id="room_number" class="form-control @error('room_number') is-invalid @enderror" value="{{ old('room_number') }}" placeholder="مثال: 101">
                        @error('room_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary px-4 fw-bold">💾 حفظ البيانات</button>
                    <a href="{{ route('doctors.index') }}" class="btn btn-secondary px-4 me-2">إلغاء</a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection