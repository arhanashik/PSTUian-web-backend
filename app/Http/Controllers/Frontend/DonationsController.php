<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

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
}
