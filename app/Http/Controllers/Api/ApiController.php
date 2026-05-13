<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

abstract class ApiController extends Controller
{
    protected function success(mixed $data = null, string $message = '', int $status = 200): JsonResponse
    {
        $response = ['success' => true];
        if ($message)  $response['message'] = $message;
        if (!is_null($data)) $response['data'] = $data;

        return response()->json($response, $status);
    }

    protected function created(mixed $data = null, string $message = 'تم الإنشاء بنجاح'): JsonResponse
    {
        return $this->success($data, $message, 201);
    }

    protected function error(string $message, int $status = 400, mixed $errors = null): JsonResponse
    {
        $response = ['success' => false, 'message' => $message];
        if ($errors) $response['errors'] = $errors;

        return response()->json($response, $status);
    }

    protected function notFound(string $message = 'العنصر غير موجود'): JsonResponse
    {
        return $this->error($message, 404);
    }
}
