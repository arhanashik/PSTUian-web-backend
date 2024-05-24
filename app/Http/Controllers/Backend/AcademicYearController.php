<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Enum\DeleteStatus;
use App\Http\Requests\AcademicYearRequest;
use App\Services\AcademicYearService;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AcademicYearController extends BaseController
{
    public function __construct(private readonly AcademicYearService $academicyearservice)
    {
    }

    /**
     * @OA\GET(
     *     path="/api/v1/backend/academic-years",
     *     tags={"Academic-Year-Backend"},
     *     summary="Get Academic-Year list as array",
     *     description="Get Academic-Year list as array",
     *     @OA\Parameter(name="deleted", description="Delete type, Not Deleted=0, Soft=1, Hard=9", example="0", required=false, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get AcademicYear list as array"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $AcademicYear = $this->academicyearservice->all(
                ['deleted' => request()->deleted ?? DeleteStatus::NOT_DELETED]
            );
            $status = Response::HTTP_OK;
            $total = count($AcademicYear) ?? 0;
            $message = 'Total ' . $total . ' ' . Str::plural('AcademicYear', $total) . ' found.';
            return $this->responseJson($AcademicYear, $status, $message);
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/backend/academic-years",
     *     tags={"Academic-Year-Backend"},
     *     summary="Add new Academic-Year",
     *     description="",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="2018-2019"),
     *        ),
     *    ),
     *    @OA\Response(response=201,description="Academic-Year created successfully"),
     *    @OA\Response(response=400, description="Bad request"),
     *    @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function store(AcademicYearRequest $request): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->academicyearservice->create(($request->all())),
                Response::HTTP_CREATED,
                __('Academic Year saved successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/backend/academic-years/{id}",
     *     tags={"Academic-Year-Backend"},
     *     summary="Update Academic-Year",
     *     description="Update Academic-Year by ID",
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="_method", description="PUT / POST", example="PUT", required=true, in="query", @OA\Schema(type="string")),
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="2018-2019", description="Insert Academic-Year"),
     *        ),
     *    ),
     *    @OA\Response(response=201,description="Academic-Year updated successfully"),
     *    @OA\Response(response=400, description="Bad request"),
     *    @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function update(AcademicYearRequest $request, int $id): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->academicyearservice->update($id, $request->all()),
                Response::HTTP_OK,
                __('Academic-Year updated successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/v1/backend/academic-years/{id}",
     *     tags={"Academic-Year-Backend"},
     *     summary="Delete Academic-Year",
     *     description="Delete a specific Academic-Year by its ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the Academic-Year to deleted",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(name="deleted", description="Delete type, Soft=1, Hard=9, Keep empty for permanent delete", example="1", required=false, in="query", @OA\Schema(type="integer")),
     *     @OA\Response(
     *          response=200,
     *          description="Academic-Year deleted successful",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Academic-Year deleted successfully."
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Academic-Year not found"
     *     ),
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
                $this->academicyearservice->delete(
                    $id,
                    $deleteStatusInt
                ),
                Response::HTTP_OK,
                __('Academic-Year deleted successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }
}
