<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Xử lý khi người dùng không được xác thực.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // Nếu request không yêu cầu JSON, trả về null (không chuyển hướng)
        if (!$request->expectsJson()) {
            return null;
        }

        // Trả về JSON thông báo "Unauthorized" với mã HTTP 401
        abort(response()->json([
            'success' => false,
            'message' => 'Unauthorized',
        ], 401));
    }
}
