<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Enum\DeleteStatus;
use App\Http\Requests\RequestBloodDonationRequest;
use App\Services\BloodRequestService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseController;
use Symfony\Component\HttpFoundation\Response;
use App\Utilities\DeleteMessage;

class BloodDonationRequestController extends BaseController
{
    public function __construct(private readonly BloodRequestService $bloodRequestService)
    {
    }

    /**
     * @OA\GET(
     *     path="/api/v1/backend/blood-requests",
     *     tags={"Blood-Requests-Backend"},
     *     summary="Get blood requests list as array",
     *     @OA\Parameter(name="deleted", description="Delete type, Not Deleted=0, Soft=1, Hard=9", example="0", required=false, in="query", @OA\Schema(type="integer")),
     *     description="",
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get blood requests list as array"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $bloodRequests = $this->bloodRequestService->getPaginatedData(
                null,
                ['deleted' => request()->deleted ?? DeleteStatus::NOT_DELETED]
            );
            $status = Response::HTTP_OK;
            $total = $bloodRequests['total'] ?? 0;
            $message = 'Total ' . $total . ' ' . Str::plural('blood requests', $total) . ' found.';
            return $this->responseJson($bloodRequests, $status, $message);
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }


    /**
     * @OA\GET(
     *     path="/api/v1/backend/blood-requests/{id}",
     *     tags={"Blood-Requests-Backend"},
     *     summary="Get blood request",
     *     description="Get blood request",
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get a blood request"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(int $id)
    {
        try {
            $bloodRequest = $this->bloodRequestService->getById($id);
            return $this->responseJson(
                $bloodRequest,
                Response::HTTP_OK,
                __('Blood request found')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/backend/blood-requests",
     *     tags={"Blood-Requests-Backend"},
     *     summary="Add blood donation request",
     *     description="",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"blood_group", "need_befor", "phone", "message"},
     *             @OA\Property(property="blood_group", type="string", example="B+"),
     *             @OA\Property(property="need_before", type="date", example="2024-05-25"),
     *             @OA\Property(property="phone", type="number", example="01403487219"),
     *             @OA\Property(property="message", type="text", example="Blood need for a pragnenet patient"),
     *        ),
     *    ),
     *    @OA\Response(response=201,description="Blood donation request created successfully"),
     *    @OA\Response(response=400, description="Bad request"),
     *    @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function store(RequestBloodDonationRequest $request): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->bloodRequestService->create($request->all()),
                Response::HTTP_CREATED,
                __('Blood donation request created successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/backend/blood-requests/{id}",
     *     tags={"Blood-Requests-Backend"},
     *     summary="Update Blood donation request",
     *     description="Update Blood donation request api",
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="_method", description="PUT / POST", example="PUT", required=true, in="query", @OA\Schema(type="string")),
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"blood_group", "need_befor", "phone", "message"},
    *                   @OA\Property(property="blood_group", type="string", example="B+"),
    *                   @OA\Property(property="need_before", type="date", example="2024-05-25"),
    *                   @OA\Property(property="phone", type="number", example="01403487219"),
    *                   @OA\Property(property="message", type="text", example="Blood need for a pragnenet patient"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="Blood donation request updated successfully"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found")
     * )
     */
    public function update(RequestBloodDonationRequest $request, int $id): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->bloodRequestService->update($id, $request->all()),
                Response::HTTP_OK,
                __('Blood donation request updated successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }


    /**
     * @OA\Delete(
     *      path="/api/v1/backend/blood-requests/{id}",
     *      tags={"Blood-Requests-Backend"},
     *      summary="Blood donation request",
     *      description="Blood donation request by ID",
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
            $deleteMessage = new DeleteMessage($deleteStatusInt, 'Blood donation request');

            return $this->responseJson(
                $this->bloodRequestService->delete(
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

        /**
     * @OA\GET(
     *     path="/api/v1/backend/blood-requests/confirm/{id}",
     *     tags={"Blood-Requests-Backend"},
     *     summary="Get blood request",
     *     description="Get blood request",
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get a blood request"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function ChangeConfirmation(int $id)
    {
        // $isconfirm = $this->bloodRequestService->getById($id)->isConfirm === 0 ? 1 : 0 ;
        // return $isconfirm;
        try {
            $confirmation = $this->bloodRequestService->getById($id)->isConfirm === 0 ? 1 : 0 ;
            $object = $this->bloodRequestService->update($id,['isConfirm'=> (int)$confirmation]);
            
            return $this->responseJson(
                $object,
                Response::HTTP_OK,
                $confirmation ===  1 ? __('Blood donation request is confirma ') : __('Blood donation request is unconfirm ')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }
}
