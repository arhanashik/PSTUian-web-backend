<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Enum\DeleteStatus;
use App\Http\Requests\BloodDonationRequest;
use App\Http\Requests\RequestBloodDonationRequest;
use App\Services\BloodDonationService;
use App\Services\BloodRequestService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseController;
use Symfony\Component\HttpFoundation\Response;
use App\Utilities\DeleteMessage;

class BloodDonationController extends BaseController
{
    public function __construct(private readonly BloodDonationService $bloodDonationService)
    {
    }


    /**
     * @OA\GET(
     *     path="/api/v1/backend/blood-donations",
     *     tags={"Blood-donations-Backend"},
     *     summary="Get blood donations list as array",
     *     @OA\Parameter(name="deleted", description="Delete type, Not Deleted=0, Soft=1, Hard=9", example="0", required=false, in="query", @OA\Schema(type="integer")),
     *     description="",
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get blood donations list as array"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $bloodDonations = $this->bloodDonationService->getPaginatedData(
                null,
                ['deleted' => request()->deleted ?? DeleteStatus::NOT_DELETED]
            );
            $status = Response::HTTP_OK;
            $total = $bloodDonations['total'] ?? 0;
            $message = 'Total ' . $total . ' ' . Str::plural('blood donatons', $total) . ' found.';
            return $this->responseJson($bloodDonations, $status, $message);
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/backend/blood-donations",
     *     tags={"Blood-donations-Backend"},
     *     summary="Add blood donation",
     *     description="",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "user_type", "request_id", "date", "info"},
     *             @OA\Property(property="user_id", type="integer", example="1"),
     *             @OA\Property(property="user_type", type="string", example="student"),
     *             @OA\Property(property="request_id", type="integer", example="1"),
     *             @OA\Property(property="date", type="date", example="2014-05-23"),
     *             @OA\Property(property="info", type="text", example="Need for patient")
     *        ),
     *    ),
     *    @OA\Response(response=201,description="Blood donation created successfully"),
     *    @OA\Response(response=400, description="Bad request"),
     *    @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function store(BloodDonationRequest $request): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->bloodDonationService->create($request->all()),
                Response::HTTP_CREATED,
                __('Blood donation save successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/backend/blood-donations/{id}",
     *     tags={"Blood-donations-Backend"},
     *     summary="Get blood donation",
     *     description="Get blood donation",
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get a blood donation"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(int $id)
    {
        try {
            $bloodDonation = $this->bloodDonationService->getById($id);
            return $this->responseJson(
                $bloodDonation,
                Response::HTTP_OK,
                __('Blood donation found')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    public function edit(string $id)
    {
        //
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/backend/blood-donations/{id}",
     *     tags={"Blood-donations-Backend"},
     *     summary="Update Blood donation",
     *     description="Update Blood donation api",
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="_method", description="PUT / POST", example="PUT", required=true, in="query", @OA\Schema(type="string")),
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                      required={"user_id", "user_type", "request_id", "date", "info"},
     *                      @OA\Property(property="user_id", type="integer", example="1"),
     *                      @OA\Property(property="user_type", type="string", example="student"),
     *                      @OA\Property(property="request_id", type="integer", example="1"),
     *                      @OA\Property(property="date", type="date", example="2014-05-23"),
     *                      @OA\Property(property="info", type="text", example="Need for patient")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="Blood donation request updated successfully"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found")
     * )
     */
    public function update(BloodDonationRequest $request, int $id): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->bloodDonationService->update($id, $request->all()),
                Response::HTTP_OK,
                __('Blood donation updated successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }


    /**
     * @OA\Delete(
     *      path="/api/v1/backend/blood-donations/{id}",
     *      tags={"Blood-donations-Backend"},
     *      summary="Blood donation delete",
     *      description="Blood donation delete",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the Blood donation request to delete",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Parameter(name="deleted", description="Delete type, Soft=1, Hard=9, Keep empty for permanent delete", example="1", required=false, in="query", @OA\Schema(type="integer")),
     *      @OA\Response(
     *          response=200,
     *          description="Blood donation request deleted successful",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Blood donation request not found"
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
            $deleteStatusInt = (int) $request->deleted ?? DeleteStatus::SOFT_DELETE;
            $deleteMessage = new DeleteMessage($deleteStatusInt, 'Blood donation');

            return $this->responseJson(
                $this->bloodDonationService->delete(
                    $id,
                    $deleteStatusInt
                ),
                Response::HTTP_OK,
                __($deleteMessage->format())
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }
}
