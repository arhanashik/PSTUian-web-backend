<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use Exception;
use Illuminate\Support\Str;
use App\Http\Controllers\BaseController;
use App\Http\Requests\FacultyRequest;
use App\Http\Requests\FacultyUpdateRequest;
use App\Services\FacultyService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FacultyController extends BaseController
{
    public function __construct(private readonly FacultyService $facultyService)
    {
    }

    /**
     * @OA\GET(
     *     path="/api/v1/backend/faculties",
     *     tags={"Faculties"},
     *     summary="Get Faculty List as Array",
     *     description="Get Faculty List as Array",
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get Faculty List as Array"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $faculties = $this->facultyService->getPaginatedFaculties();
            $total = $faculties['total'] ?? 0;
            $message = 'Total ' . $total . ' ' . Str::plural('faculty', $total) . ' found.';

            return $this->responseJson($faculties, Response::HTTP_OK, $message);
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/backend/faculties",
     *     tags={"Faculties"},
     *     summary="Admin insert new Faculty",
     *     description="Implement an API endpoint for administrators to effortlessly add new faculty entries.",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"short_title", "title"},
     *             @OA\Property(property="short_title", type="string", example="CSE", description="Name of the faculty"),
     *             @OA\Property(property="title", type="string", example="Computer Science And Engineering", description="Name of the faculty"),
     *        ),
     *    ),
     *    @OA\Response(response=201,description="faculty created successfully"),
     *    @OA\Response(response=400, description="Bad request"),
     *    @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function store(FacultyRequest $request): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->facultyService->storeFaculty($request->all()),
                Response::HTTP_CREATED,
                __('Faculty saved successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/backend/faculties/{id}",
     *     tags={"Faculties"},
     *     summary="Update faculty",
     *     description="Update faculty by ID",
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="_method", description="PUT / POST", example="PUT", required=true, in="query", @OA\Schema(type="string")),
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"short_title", "title"},
     *             @OA\Property(property="id", description="ID", type="integer", example=1),
     *             @OA\Property(property="short_title", type="string", example="CSE", description="Name of the faculty"),
     *             @OA\Property(property="title", type="string", example="Computer Science And Engineering", description="Name of the faculty"),
     *        ),
     *    ),
     *    @OA\Response(response=201,description="faculty updated successfully"),
     *    @OA\Response(response=400, description="Bad request"),
     *    @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function update(FacultyRequest $request, int $id): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->facultyService->updateFaculty($id, $request->all()),
                Response::HTTP_OK,
                __('Faculty updated successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/frontend/faculties/{id}",
     *     tags={"Faculties"},
     *     summary="Show faculty by id",
     *     description="",
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     security={{"bearer":{}}},
     *    @OA\Response(response=201,description="faculty updated successfully"),
     *    @OA\Response(response=400, description="Bad request"),
     *    @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function showFacultyById(int $id): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->facultyService->FacultyById($id),
                Response::HTTP_CREATED,
                __('Faculty fetch successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }
}
