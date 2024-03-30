<?php

declare(strict_types=1);

namespace App\Traits;

use Exception;
use Illuminate\Http\JsonResponse;

trait Responsable
{
    /**
     * Response Json.
     *
     * @param array|object|mixed $data
     * @param integer $status
     * @param [type] $message
     *
     * @return JsonResponse
     */
    public function responseJson($data, int $status = 200, $message = null): JsonResponse
    {
        return response()->json(
            [
                'data' => $data,
                'success' => in_array($status, [200, 201, 204]) ? true : false,
                'message' => $message,
            ]
        );
    }

    public function responseErrorJson(Exception $exception): JsonResponse
    {
        return response()->json(
            [
                'data' => [],
                'success' => false,
                'message' => config('app.debug') ?
                    $exception->getMessage()
                    : __('Something went wrong, Please try again later.')
            ]
        );
    }
}