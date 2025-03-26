<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected function sendResponse($data = null, string $message = "Success", int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => $status >= 200 && $status < 300,
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}
