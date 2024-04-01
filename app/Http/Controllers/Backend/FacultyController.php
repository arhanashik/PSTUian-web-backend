<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Models\Faculty;
use Exception;
use App\Http\Controllers\BaseController;
use App\Http\Requests\FacultyRequest;
use App\Services\FacultyService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FacultyController extends BaseController
{
    public function __construct(private readonly FacultyService $facultyService) 
    {
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
    
    public function store(FacultyRequest $facultyRequest): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->facultyService->storeFaculty($facultyRequest->all()),
                Response::HTTP_CREATED,
                __('Faculty saved successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }
    
    /**
     * @OA\PUT(
     *     path="/api/v1/backend/faculties/1",
     *     tags={"Faculties"},
     *     summary="Admin update Faculty",
     *     description="Implement an API endpoint for administrators to effortlessly update faculty.",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"short_title", "title"},
     *             @OA\Property(property="short_title", type="string", example="CSE", description="Name of the faculty"),
     *             @OA\Property(property="title", type="string", example="Computer Science And Engineering", description="Name of the faculty"),
     *        ),
     *    ),
     *    @OA\Response(response=201,description="faculty updated successfully"),
     *    @OA\Response(response=400, description="Bad request"),
     *    @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function update(FacultyRequest $facultyRequest, $id): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->facultyService->updateFaculty($id, $facultyRequest->all()),
                Response::HTTP_OK,
                __('Faculty updated successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }
    
}
