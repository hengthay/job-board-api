<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;

abstract class Controller
{
    /**
     * Standard API response method for success.
     *
     * @param  mixed $result The data payload (e.g., model, collection, array).
     * @param  string $message A descriptive success message.
     * @param  int $code HTTP status code (default 200).
     * @return JsonResponse
     */
    public function handleResponse(mixed $data = null, string $message, int $code = 200) : JsonResponse {
        $response = [
            'success' => true,
            'data' => $data,
            'message' => $message
        ];

        return response()->json($response, $code);
    }

    /**
     * Standard API response method for errors.
     *
     * @param  string $error The main error message.
     * @param  array $errorMessages Detailed error messages (optional).
     * @param  int $code HTTP status code (default 404).
     * @return JsonResponse
     */
    public function handleErrorResponse(mixed $data = null, string $message, int $code = 400) : JsonResponse {
        $response = [
            'success' => false,
            'data' => $data,
            'message' => $message
        ];

        return response()->json($response, $code);
    }
}
