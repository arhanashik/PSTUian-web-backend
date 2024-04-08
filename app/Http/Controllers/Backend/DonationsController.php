<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use Exception;
use App\Enum\DeleteStatus;
use Illuminate\Support\Str;
use App\Http\Controllers\BaseController;
use App\Services\DonationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DonationsController extends BaseController
{
    public function __construct(private readonly DonationService $donationService)
    {
    }

    /**
     * @OA\GET(
     *     path="/api/v1/backend/donations",
     *     tags={"Backend-Donations"},
     *     summary="Get Donation List as Array",
     *     @OA\Parameter(name="deleted", description="Delete type, Not Deleted=0, Soft=1, Hard=9", example="0", required=false, in="query", @OA\Schema(type="integer")),
     *     description="Get Donation List as Array",
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get Donation List as Array"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $donations = $this->donationService->getPaginatedData(
                null,
                ['deleted' => request()->deleted ?? DeleteStatus::NOT_DELETED]
            );
            $total = $donations['total'] ?? 0;
            $message = 'Total ' . $total . ' ' . Str::plural('donation', $total) . ' found.';

            return $this->responseJson($donations, Response::HTTP_OK, $message);
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\PUT(
     *      path="/api/v1/backend/donations/confirm/{id}",
     *      tags={"Backend-Donations"},
     *      summary="Confirm Donation",
     *      description="Confirm Donation by its ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the donation to confirm",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Donation confirmed successful",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Donation confirmed successfully."
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Donation not found"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *      )
     * )
     */
    public function confirm(int $id): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->donationService->confirm($id),
                Response::HTTP_OK,
                __('Donation confirmed successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }


    /**
     * @OA\PUT(
     *      path="/api/v1/backend/donations/unconfirm/{id}",
     *      tags={"Backend-Donations"},
     *      summary="Unconfirm Donation",
     *      description="Unconfirm Donation by its ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the donation to unconfirm",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Donation unconfirmed successful",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Donation unconfirmed successfully."
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Donation not found"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *      )
     * )
     */
    public function unconfirm(int $id): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->donationService->unconfirm($id),
                Response::HTTP_OK,
                __('Donation unconfirmed successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/backend/donations/{id}",
     *      tags={"Backend-Donations"},
     *      summary="Delete a donation",
     *      description="Delete a donation by its ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the donation to delete",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Parameter(name="deleted", description="Delete type, Soft=1, Hard=9, Keep empty for permanent delete", example="1", required=false, in="query", @OA\Schema(type="integer")),
     *      @OA\Response(
     *          response=200,
     *          description="Donation deleted successful",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Donation deleted successfully."
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Donation not found"
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
                $this->donationService->delete(
                    $id,
                    $deleteStatusInt
                ),
                Response::HTTP_OK,
                __('Donation deleted state successfully update.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }
}
