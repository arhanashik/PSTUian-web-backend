<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use Exception;
use App\Enum\DeleteStatus;
use Illuminate\Support\Str;
use App\Http\Controllers\BaseController;
use App\Http\Requests\EmployeeRequest;
use App\Services\EmployeeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends BaseController
{
    public function __construct(private readonly EmployeeService $employeeService)
    {
    }

    /**
     * @OA\GET(
     *     path="/api/v1/backend/employees",
     *     tags={"Employees-Backend"},
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
     *     path="/api/v1/backend/employees/{id}",
     *     tags={"Employees-Backend"},
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

    /**
     * @OA\POST(
     *     path="/api/v1/backend/employees",
     *     tags={"Employees-Backend"},
     *     summary="Insert new employee",
     *     description="Implement an API endpoint for administrators to effortlessly add new employee entries.",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *        @OA\JsonContent(
     *               required={"name", "designation", "department", "phone", "address", "image_url", "faculty_id"},
     *               @OA\Property(property="name", type="string", example="John Doe", description="Name of the employee"),
     *               @OA\Property(property="designation", type="string", example="Software Engineer", description="Designation of the employee"),
     *               @OA\Property(property="department", type="string", example="Engineering", description="Department of the employee"),
     *               @OA\Property(property="phone", type="string", example="123-456-7890", description="Phone number of the employee"),
     *               @OA\Property(property="address", type="string", example="123 Main St, City, State, ZIP", description="Address of the employee"),
     *               @OA\Property(property="image_url", type="string", example="http://example.com/image.jpg", description="Image URL of the employee"),
     *               @OA\Property(property="faculty_id", type="integer", example=1, description="Faculty ID associated with the employee")
     *      )
     *    ),
     *    @OA\Response(response=201,description="Employee created successfully"),
     *    @OA\Response(response=400, description="Bad request"),
     *    @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function store(EmployeeRequest $request): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->employeeService->create($request->all()),
                Response::HTTP_CREATED,
                __('Employee created successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/backend/employees/{id}",
     *     tags={"Employees-Backend"},
     *     summary="Update employee",
     *     description="Update employee by ID",
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="_method", description="PUT / POST", example="PUT", required=true, in="query", @OA\Schema(type="string")),
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *               required={"name", "faculty_id", "total_student"},
     *               @OA\Property(property="name", type="string", example="John Doe", description="Name of the employee"),
     *               @OA\Property(property="designation", type="string", example="Software Engineer", description="Designation of the employee"),
     *               @OA\Property(property="department", type="string", example="Engineering", description="Department of the employee"),
     *               @OA\Property(property="phone", type="string", example="123-456-7890", description="Phone number of the employee"),
     *               @OA\Property(property="address", type="string", example="123 Main St, City, State, ZIP", description="Address of the employee"),
     *               @OA\Property(property="image_url", type="string", example="http://example.com/image.jpg", description="Image URL of the employee"),
     *               @OA\Property(property="faculty_id", type="integer", example=1, description="Faculty ID associated with the employee")
     *         ),
     *    ),
     *    @OA\Response(response=201,description="Employee updated successfully"),
     *    @OA\Response(response=400, description="Bad request"),
     *    @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function update(EmployeeRequest $request, int $id): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->employeeService->update($id, $request->all()),
                Response::HTTP_OK,
                __('Employee updated successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/backend/employees/{id}",
     *      tags={"Employees-Backend"},
     *      summary="Delete a employee",
     *      description="Delete a employee by its ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the employee to delete",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Parameter(name="deleted", description="Delete type, Soft=1, Hard=9, Keep empty for permanent delete", example="1", required=false, in="query", @OA\Schema(type="integer")),
     *      @OA\Response(
     *          response=200,
     *          description="Employee deleted successful",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Employee deleted successfully."
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Employee not found"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *      )
     * )
     */
    public function destroy(int $id, Request $request): JsonResponse
    {
        try {
            $deleteStatusInt = (int)$request->deleted ?? DeleteStatus::SOFT_DELETE;
            
            return $this->responseJson(
                $this->employeeService->delete(
                    $id,
                    $deleteStatusInt
                ),
                Response::HTTP_OK,
                __('Employee deleted state successfully update.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }
}
