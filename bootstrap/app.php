<?php

use App\Helpers\ApiResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(\App\Http\Middleware\XssSanitization::class);
        $middleware->api(prepend: [
            \App\Http\Middleware\ApiResponseMiddleware::class
            //            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            '/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ValidationException $exception, Request $request) {
            if ($request->expectsJson()) {
                return ApiResponse::error($exception->getMessage(), 422, $exception->errors());
            }
        });

        $exceptions->render(function (\Exception $exception, Request $request) {
            if ($request->expectsJson()) {
                return ApiResponse::error($exception->getMessage(), 500);
            }

            return true;
        });

    })->create();
