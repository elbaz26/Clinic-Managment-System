<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'نظام إدارة العيادة')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; background-color: #f1f5f9; min-height: 100vh; }
        .sidebar { width: 260px; background: #1e3a8a; color: #ffffff; min-height: 100vh; position: fixed; top: 0; right: 0; z-index: 1000; box-shadow: -4px 0 15px rgba(0,0,0,0.1); }
        .sidebar .brand { padding: 22px 20px; font-size: 20px; font-weight: 900; border-bottom: 1px solid rgba(255,255,255,0.1); background: #172554; }
        .sidebar .nav-link { color: #93c5fd; padding: 14px 22px; font-weight: 700; font-size: 15px; border-right: 4px solid transparent; transition: all 0.2s ease; display: flex; align-items: center; gap: 10px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #ffffff; background: rgba(255,255,255,0.08); border-right-color: #3b82f6; }
        .main-wrapper { margin-right: 260px; min-height: 100vh; display: flex; flex-direction: column; }
        .top-navbar { background: #ffffff; padding: 15px 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.04); display: flex; justify-content: space-between; align-items: center; }
        .content-body { padding: 30px; flex: 1; }
        .role-badge { font-size: 12px; padding: 4px 10px; border-radius: 20px; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="brand d-flex align-items-center justify-content-between">
            <span>🏥 عيادتي Clinic</span>
        </div>
        <nav class="mt-3">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">📊 لوحة التحكم</a>
            <a href="{{ route('patients.index') }}" class="nav-link {{ request()->routeIs('patients.*') ? 'active' : '' }}">👥 إدارة المرضى</a>
            <a href="{{ route('doctors.index') }}" class="nav-link {{ request()->routeIs('doctors.*') ? 'active' : '' }}">👨‍⚕️ إدارة الأطباء</a>
            <a href="{{ route('appointments.index') }}" class="nav-link {{ request()->routeIs('appointments.*') ? 'active' : '' }}">📅 جدول المواعيد</a>
        </nav>
    </aside>

    <div class="main-wrapper">
        <header class="top-navbar">
            <div class="d-flex align-items-center gap-2">
                <span class="text-muted fs-6">مرحباً بك،</span>
                <strong class="text-primary fs-5">{{ Auth::user()?->name ?? 'مستخدم' }}</strong>
                <span class="badge bg-primary role-badge">{{ Auth::user()?->role ?? 'user' }}</span>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm px-3 fw-bold">🚪 تسجيل الخروج</button>
            </form>
        </header>

        <main class="content-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>