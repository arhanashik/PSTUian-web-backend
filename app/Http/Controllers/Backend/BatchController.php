<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use Exception;
use App\Enum\DeleteStatus;
use Illuminate\Support\Str;
use App\Http\Controllers\BaseController;
use App\Http\Requests\BatchRequest;
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
     *     path="/api/v1/backend/batches",
     *     tags={"Backend-Batches"},
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
     *     path="/api/v1/backend/batches/{id}",
     *     tags={"Backend-Batches"},
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
            return $this->responseJson($batch, Response::HTTP_OK, $batch ? __('Batch found') : __('Batch not found'));
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/backend/batches",
     *     tags={"Backend-Batches"},
     *     summary="Insert new batch",
     *     description="Implement an API endpoint for administrators to effortlessly add new batch entries.",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "session", "faculty_id", "total_student"},
     *             @OA\Property(property="name", type="string", example="CSE 12th Batch", description="Name of the batch"),
     *             @OA\Property(property="title", type="string", example="Baundule 12", description="Title of the batch"),
     *             @OA\Property(property="session", type="string", example="2014-15", description="Session of the batch"),
     *             @OA\Property(property="faculty_id", type="integer", example="1", description="Faculty id of the batch"),
     *             @OA\Property(property="total_student", type="integer", example="67", description="Total students in the batch"),
     *        ),
     *    ),
     *    @OA\Response(response=201,description="Batch created successfully"),
     *    @OA\Response(response=400, description="Bad request"),
     *    @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function store(BatchRequest $request): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->batchService->create($request->all()),
                Response::HTTP_CREATED,
                __('Batch saved successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/backend/batches/{id}",
     *     tags={"Backend-Batches"},
     *     summary="Update batch",
     *     description="Update batch by ID",
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="_method", description="PUT / POST", example="PUT", required=true, in="query", @OA\Schema(type="string")),
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     * *             required={"name", "session", "faculty_id", "total_student"},
     * *             @OA\Property(property="name", type="string", example="CSE 12th Batch", description="Name of the batch"),
     * *             @OA\Property(property="title", type="string", example="Baundule 12", description="Title of the batch"),
     * *             @OA\Property(property="session", type="string", example="2014-15", description="Session of the batch"),
     * *             @OA\Property(property="faculty_id", type="integer", example="1", description="Faculty id of the batch"),
     * *             @OA\Property(property="total_student", type="integer", example="67", description="Total students in the batch"),
     * *        ),
     *    ),
     *    @OA\Response(response=201,description="Batch updated successfully"),
     *    @OA\Response(response=400, description="Bad request"),
     *    @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function update(BatchRequest $request, int $id): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->batchService->update($id, $request->all()),
                Response::HTTP_OK,
                __('Batch updated successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }
    /**
     * @OA\Delete(
     *      path="/api/v1/backend/batches/{id}",
     *      tags={"Backend-Batches"},
     *      summary="Delete a batch",
     *      description="Delete a batch by its ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the batch to delete",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Batch deleted successful",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Batch deleted successfully."
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Batch not found"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *      )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->batchService->delete($id),
                Response::HTTP_OK,
                __('Batch deleted successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }
}
