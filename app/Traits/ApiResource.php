<?php


namespace App\Traits;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResource
{
    use Validation, Positions;

    public function dataResponse($data): JsonResponse
    {
        return response()->json(['content' => $data], Response::HTTP_OK);
    }

    public function successResponse(string $message, $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json(['success' => $message, 'code' => $code], $code);
    }

    public function errorResponse($message, $code = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }
}
