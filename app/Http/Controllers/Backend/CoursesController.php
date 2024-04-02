<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Requests\CourseRequest;
use Exception;
use Illuminate\Support\Str;
use App\Services\CourseService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseController;
use Symfony\Component\HttpFoundation\Response;

class CoursesController extends BaseController
{
    public function __construct(private readonly CourseService $courseService)
    {
    }

    /**
     * @OA\GET(
     *     path="/api/v1/backend/courses",
     *     tags={"Courses"},
     *     summary="Get courses list as array",
     *     description="",
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get courses list as array"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $courses = $this->courseService->getPaginatedDatata();
            $status = Response::HTTP_OK;
            $total = $courses['total'] ?? 0;
            $message = 'Total ' . $total . ' ' . Str::plural('courses', $total) . ' found.';
            return $this->responseJson($courses, $status, $message);
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/backend/courses",
     *     tags={"Courses"},
     *     summary="Add new course",
     *     description="",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"course_code", "course_title", "credit_hour", "faculty_id"},
     *             @OA\Property(property="course_code", type="string", example="CCE-311"),
     *             @OA\Property(property="course_title", type="string", example="Computer & Communication Engineering"),
     *             @OA\Property(property="credit_hour", type="string", example="27"),
     *             @OA\Property(property="faculty_id", type="number", example="1"),
     *        ),
     *    ),
     *    @OA\Response(response=201,description="Course created successfully"),
     *    @OA\Response(response=400, description="Bad request"),
     *    @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function store(CourseRequest $request): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->courseService->create(($request->all())),
                Response::HTTP_CREATED,
                __('Course saved successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/backend/courses/{id}",
     *     tags={"Courses"},
     *     summary="Course update api ",
     *     description="",
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="_method", description="PUT / POST", example="PUT", required=true, in="query", @OA\Schema(type="string")),
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"course_code", "course_title", "credit_hour", "faculty_id"},
     *             @OA\Property(property="course_code", type="string", example="CCE-311"),
     *             @OA\Property(property="course_title", type="string", example="Computer & Communication Engineering"),
     *             @OA\Property(property="credit_hour", type="string", example="27"),
     *             @OA\Property(property="faculty_id", type="number", example="1"),
     *        ),
     *    ),
     *    @OA\Response(response=201,description="faculty updated successfully"),
     *    @OA\Response(response=400, description="Bad request"),
     *    @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function update(CourseRequest $request, int $id): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->courseService->update($id, $request->all()),
                Response::HTTP_OK,
                __('Course updated successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }
}
