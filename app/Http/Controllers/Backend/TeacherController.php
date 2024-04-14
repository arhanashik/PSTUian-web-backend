<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;


use App\Enum\DeleteStatus;
use App\Services\TeacherService;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseController;
use Symfony\Component\HttpFoundation\Response;

class  TeacherController extends BaseController
{
    public function __construct(private readonly TeacherService $teacherService)
    {
    }

    /**
     * @OA\GET(
     *     path="/api/v1/backend/teachers",
     *     tags={"Teachers"},
     *     summary="Get Teachers list as array",
     *     description="",
     *     @OA\Parameter(name="deleted", description="Delete type, Not Deleted=0, Soft=1, Hard=9", example="0", required=false, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get Teachers list as array"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $courses = $this->teacherService->getPaginatedData(
                null,
                ['deleted' => request()->deleted ?? DeleteStatus::NOT_DELETED]
            );
            $status = Response::HTTP_OK;
            $total = $courses['total'] ?? 0;
            $message = 'Total ' . $total . ' ' . Str::plural('teachers', $total) . ' found.';
            return $this->responseJson($courses, $status, $message);
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }
}
