<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     */
    public function report(Throwable $exception): void
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
{
    if ($exception instanceof UnauthorizedHttpException) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized',
        ], 401);
    }

    if ($exception instanceof TokenExpiredException) {
        return response()->json([
            'success' => false,
            'message' => 'Token has expired',
        ], 401);
    }

    if ($exception instanceof TokenInvalidException) {
        return response()->json([
            'success' => false,
            'message' => 'Token is invalid',
        ], 401);
    }

    if ($exception instanceof JWTException) {
        return response()->json([
            'success' => false,
            'message' => 'Token is missing',
        ], 401);
    }

    return parent::render($request, $exception);
}
}
