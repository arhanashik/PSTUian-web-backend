<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backend;

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
     *     path="/api/v1/backend/AccountOptions",
     *     tags={"Backend-AccountOptions"},
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



    /**
     * @OA\POST(
     *     path="/api/v1/backend/AccountOptions",
     *     tags={"Backend-Backend-AccountOptions"},
     *     summary="Create Account-Option",
     *     description="You can send a donation to the following accounts.",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"donation_option"},
     *             @OA\Property(property="donation_option", type="string", example="Bikash-01403487219", description="Name of the Donor"),
     *        ),
     *    ),
     *    @OA\Response(response=201,description="Option created successfully"),
     *    @OA\Response(response=400, description="Bad request"),
     *    @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function store(AccountOptionRequest $request): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->accountOptionService->createAccountOption($request->all()),
                Response::HTTP_CREATED,
                __('Your Option request has been saved successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }
}
