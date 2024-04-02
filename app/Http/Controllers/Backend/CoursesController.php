<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

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
         return $this->responseJson($courses,$status,$message);
       } catch (Exception $exception) {
        return $this->responseErrorJson($exception);
       }
    }
}
