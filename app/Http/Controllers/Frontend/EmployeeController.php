<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use Exception;
use App\Enum\DeleteStatus;
use Illuminate\Support\Str;
use App\Http\Controllers\BaseController;
use App\Services\EmployeeService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends BaseController
{
    public function __construct(private readonly EmployeeService $employeeService)
    {
    }

    /**
     * @OA\GET(
     *     path="/api/v1/frontend/employees",
     *     tags={"Frontend-employees"},
     *     summary="Get Employee List as Array",
     *     description="Get Employee List as Array",
     *     @OA\Parameter(name="deleted", description="Delete type, Not Deleted=0, Soft=1, Hard=9", example="0", required=false, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get Employee List as Array"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $employees = $this->employeeService->getPaginatedData(
                null,
                ['deleted' => request()->deleted ?? DeleteStatus::NOT_DELETED]
            );
            $total = $employees['total'] ?? 0;
            $message = 'Total ' . $total . ' ' . Str::plural('employee', $total) . ' found.';

            return $this->responseJson($employees, Response::HTTP_OK, $message);
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/frontend/employees/{id}",
     *     tags={"Frontend-employees"},
     *     summary="Get a Employee",
     *     description="Get a Employee",
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get a Employee"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(int $id): JsonResponse
    {
        try {
            $employee = $this->employeeService->getById($id);
            return $this->responseJson(
                $employee,
                Response::HTTP_OK,
                __('Employee found')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }
}
