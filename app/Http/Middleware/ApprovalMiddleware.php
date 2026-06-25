<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApprovalMiddleware
{
    /**
     * Mengizinkan akses untuk role 'admin' ATAU 'ar' — digunakan
     * khusus untuk halaman dan aksi verifikasi/approval data pending.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $role = $request->user()?->role;

        if (!in_array($role, ['admin', 'ar'], true)) {
            abort(403, 'Anda tidak memiliki akses untuk memverifikasi data.');
        }

        return $next($request);
    }
}
