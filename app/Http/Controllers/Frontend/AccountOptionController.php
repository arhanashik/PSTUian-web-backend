<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Str;
use App\Http\Controllers\BaseController;
use App\Http\Requests\AccountOptionRequest;
use App\Services\AccountOptionService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AccountOptionController extends BaseController
{
    public function __construct(private readonly AccountOptionService $accountOptionService)
    {
    }

    /**
     * @OA\GET(
     *     path="/api/v1/frontend/AccountOptions",
     *     tags={"Frontend-AccountOptions"},
     *     summary="Get AccountOptions List as Array",
     *     description="Get AccountOptions List as Array",
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get AccountOptions List as Array"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(): JsonResponse
    {
        try {
            // Retrieve all account options
            $options = $this->accountOptionService->getAccountOptions();

            // Generate a message indicating the total number of options found
            $message = 'Total ' . count($options) . ' ' . Str::plural('options', count($options)) . ' found.';

            // Return a JSON response with the retrieved account options and a success message
            return $this->responseJson($options, Response::HTTP_OK, $message);
        } catch (Exception $exception) {
            // Handle any exceptions and return an error response
            return $this->responseErrorJson($exception);
        }
    }
}
