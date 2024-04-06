<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Requests\AcademicYearRequest;
use App\Services\AcademicYearService;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseController;
use Symfony\Component\HttpFoundation\Response;

class AcademicYearController extends BaseController
{
    public function __construct(private readonly AcademicYearService $academicyearservice)
    {
    }

    /**
     * @OA\GET(
     *     path="/api/v1/backend/academicyears",
     *     tags={"Academic-Year"},
     *     summary="Get Academic-Year list as array",
     *     description="",
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get AcademicYear list as array"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $AcademicYear = $this->academicyearservice->all();
            $status = Response::HTTP_OK;
            $total = $AcademicYear['total'] ?? 0;
            $message = 'Total ' . $total . ' ' . Str::plural('AcademicYear', $total) . ' found.';
            return $this->responseJson($AcademicYear, $status, $message);
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/backend/academicyears",
     *     tags={"Academic-Year"},
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
                __('Student saved successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/backend/academicyears/{id}",
     *     tags={"Academic-Year"},
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
     *     path="/api/v1/backend/academicyears/{id}",
     *     tags={"Academic-Year"},
     *     summary="Delete a Academic-Year",
     *     description="Delete a specific Academic-Year by its ID",
     *     @OA\Parameter(
     *         name="id",
     *         description="ID of the Academic-Year",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     security={{"bearer":{}}},
     *     @OA\Response(
     *         response=204,
     *         description="Academic-Year deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Academic-Year not found"
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->academicyearservice->delete($id),
                Response::HTTP_OK,
                __('Academic-Year deleted successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }
}
