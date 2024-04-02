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
