<?php

use App\Helpers\ApiResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response | \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     */
    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            return ApiResponse::error($exception->getMessage(), 500);
        }

        return parent::render($request, $exception);
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        return ApiResponse::error('Validation error', 422, $exception->errors());
    }
}
