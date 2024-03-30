<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use Exception;
use Illuminate\Support\Str;
use App\Http\Controllers\BaseController;
use App\Http\Requests\DonationRequest;
use App\Services\DonationService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DonationsController extends BaseController
{
    public function __construct(private readonly DonationService $donationService)
    {
    }

    /**
     * @OA\GET(
     *     path="/api/v1/frontend/donations",
     *     tags={"Frontend-Donations"},
     *     summary="Get Donation List as Array",
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
            $donations = $this->donationService->getDonations();
            $message = 'Total ' . count($donations) . ' ' . Str::plural('donation', count($donations)) . ' found.';

            return $this->responseJson($donations, Response::HTTP_OK, $message);
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/v1/frontend/donations",
     *     tags={"Frontend-Donations"},
     *     summary="Create Donation",
     *     description="Create Donation",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "info", "email", "reference"},
     *             @OA\Property(property="name", type="string", example="John Doe", description="Name of the Donor"),
     *             @OA\Property(property="info", type="string", example="Donation Information", description="Information about the Donation"),
     *             @OA\Property(property="email", type="string", example="test@example.com", description="Email of the Donor"),
     *             @OA\Property(property="reference", type="string", example="REF123456", description="Reference of the Donation"),
     *        ),
     *    ),
     *    @OA\Response(response=201,description="Create Donation"),
     *    @OA\Response(response=400, description="Bad request"),
     *    @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function store(DonationRequest $request): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->donationService->createDonation($request->all()),
                Response::HTTP_CREATED,
                __('Your Donation request has been saved successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }
}
