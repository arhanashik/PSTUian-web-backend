<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use Exception;
use Illuminate\Support\Str;
use App\Http\Controllers\BaseController;
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
     *     path="/api/v1/backend/donations",
     *     tags={"Backend-Donations"},
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
            $donations = $this->donationService->getPaginatedDonations();
            $total = $donations['total'] ?? 0;
            $message = 'Total ' . $total . ' ' . Str::plural('donation', $total) . ' found.';

            return $this->responseJson($donations, Response::HTTP_OK, $message);
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }
}
