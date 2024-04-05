<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Requests\SessionRequest;
use App\Services\SessionService;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseController;
use Symfony\Component\HttpFoundation\Response;
class SessionController extends BaseController
{
    public function __construct(private readonly SessionService $sessionService)
    {
    }

    /**
     * @OA\GET(
     *     path="/api/v1/backend/sessions",
     *     tags={"Sessions"},
     *     summary="Get sessions list as array",
     *     description="",
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get sessions list as array"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $sessions = $this->sessionService->all();
            $status = Response::HTTP_OK;
            $total = $sessions['total'] ?? 0;
            $message = 'Total ' . $total . ' ' . Str::plural('sessions', $total) . ' found.';
            return $this->responseJson($sessions, $status, $message);
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/backend/sessions",
     *     tags={"Sessions"},
     *     summary="Add new Session",
     *     description="",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="2018-2019"),
     *        ),
     *    ),
     *    @OA\Response(response=201,description="Sessions created successfully"),
     *    @OA\Response(response=400, description="Bad request"),
     *    @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function store(SessionRequest $request): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->sessionService->create(($request->all())),
                Response::HTTP_CREATED,
                __('Student saved successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/backend/sessions/{id}",
     *     tags={"Sessions"},
     *     summary="Update Session",
     *     description="Update Sessions by ID",
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="_method", description="PUT / POST", example="PUT", required=true, in="query", @OA\Schema(type="string")),
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="2018-2019", description="Insert session"),
     *        ),
     *    ),
     *    @OA\Response(response=201,description="Sessions updated successfully"),
     *    @OA\Response(response=400, description="Bad request"),
     *    @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function update(SessionRequest $request, int $id): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->sessionService->update($id, $request->all()),
                Response::HTTP_OK,
                __('Session updated successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/v1/backend/sessions/{id}",
     *     tags={"Sessions"},
     *     summary="Delete a session",
     *     description="Delete a specific session by its ID",
     *     @OA\Parameter(
     *         name="id",
     *         description="ID of the session",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     security={{"bearer":{}}},
     *     @OA\Response(
     *         response=204,
     *         description="Session deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Session not found"
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->sessionService->delete($id),
                Response::HTTP_OK,
                __('Session deleted successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }
}
