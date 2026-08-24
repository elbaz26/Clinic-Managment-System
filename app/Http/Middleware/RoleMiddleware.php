<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * معالجة الطلب وفحص صلاحية المستخدم
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. التأكد من أن المستخدم مسجل دخول
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // 2. فحص هل دور المستخدم الحالى موجود ضمن الأدوار المسموح لها
        if (!in_array($request->user()->role, $roles)) {
            abort(403, 'عفواً، ليس لديك الصلاحية لدخول هذه الصفحة! 🚫');
        }

        return $next($request);
    }
}