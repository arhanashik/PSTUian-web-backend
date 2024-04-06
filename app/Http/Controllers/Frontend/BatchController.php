<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Enum\DeleteStatus;
use Exception;
use Illuminate\Support\Str;
use App\Http\Controllers\BaseController;
use App\Services\BatchService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BatchController extends BaseController
{
    public function __construct(private readonly BatchService $batchService)
    {
    }

    /**
     * @OA\GET(
     *     path="/api/v1/frontend/batches",
     *     tags={"Frontend-Batches"},
     *     summary="Get Batch List as Array",
     *     description="Get Batch List as Array",
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get Batch List as Array"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $batches = $this->batchService->getPaginatedData(
                null,
                ['deleted' => DeleteStatus::NOT_DELETED]
            );
            $total = $batches['total'] ?? 0;
            $message = 'Total ' . $total . ' ' . Str::plural('batch', $total) . ' found.';

            return $this->responseJson($batches, Response::HTTP_OK, $message);
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/frontend/batches/{id}",
     *     tags={"Frontend-Batches"},
     *     summary="Get a Batch",
     *     description="Get a Batch",
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get a Batch"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(int $id): JsonResponse
    {
        try {
            $batch = $this->batchService->getById($id);
            return $this->responseJson($batch, Response::HTTP_OK, __('Batch found'));
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }
}
