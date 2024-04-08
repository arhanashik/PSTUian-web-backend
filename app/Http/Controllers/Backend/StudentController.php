<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Services\StudentService;
use Exception;
use App\Enum\DeleteStatus;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseController;
use Symfony\Component\HttpFoundation\Response;
class StudentController extends BaseController
{
    public function __construct(private readonly StudentService $studentService)
    {
    }

    /**
     * @OA\GET(
     *     path="/api/v1/backend/students",
     *     tags={"Students"},
     *     summary="Get Students list as array",
     *     description="",
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get Students list as array"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $courses = $this->studentService->getPaginatedData();
            $status = Response::HTTP_OK;
            $total = $courses['total'] ?? 0;
            $message = 'Total ' . $total . ' ' . Str::plural('students', $total) . ' found.';
            return $this->responseJson($courses, $status, $message);
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/backend/students/all",
     *     tags={"Students"},
     *     summary="Get Students list as array",
     *     description="",
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get Students list as array"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function all(): JsonResponse
    {
        try {
            $courses = $this->studentService->all(
                ['deleted' => request()->deleted ?? DeleteStatus::NOT_DELETED]
            );
            $status = Response::HTTP_OK;
            $total = count($courses) ?? 0;
            $message = 'Total ' . $total . ' ' . Str::plural('students', $total) . ' found.';
            return $this->responseJson($courses, $status, $message);
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }
}
