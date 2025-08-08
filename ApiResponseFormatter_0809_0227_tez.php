<?php
// 代码生成时间: 2025-08-09 02:27:49
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use Exception;

class ApiResponseFormatter
{
    /**
     * Format a successful API response.
     *
     * @param array $data Data to be returned in the response.
     * @param int $statusCode HTTP status code for the response.
     * @return \Illuminate\Http\JsonResponse
     */
    public static function successResponse($data = [], $statusCode = 200)
    {
        return Response::json([
            'status' => 'success',
            'data' => $data,
            'message' => 'Operation completed successfully',
        ], $statusCode);
    }

    /**
     * Format an API response when an error occurs.
     *
     * @param string $message Error message to be returned in the response.
     * @param int $statusCode HTTP status code for the response.
     * @return \Illuminate\Http\JsonResponse
     */
    public static function errorResponse($message, $statusCode = 500)
    {
        return Response::json([
            'status' => 'error',
            'message' => $message,
        ], $statusCode);
    }

    /**
     * Handle API exceptions and return a formatted response.
     *
     * @param Request $request Current HTTP request instance.
     * @param Exception $exception Exception that occurred during processing.
     * @return \Illuminate\Http\JsonResponse
     */
    public static function handleException(Request $request, Exception $exception)
    {
        Log::error('API Exception: ' . $exception->getMessage());
        return self::errorResponse($exception->getMessage(), $exception->getCode() ?: 500);
    }
}
