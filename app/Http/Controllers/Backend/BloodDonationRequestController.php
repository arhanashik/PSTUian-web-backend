<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Enum\DeleteStatus;
use App\Services\BloodRequestService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Str;
use App\Services\CourseService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseController;
use Symfony\Component\HttpFoundation\Response;

class BloodDonationRequestController extends BaseController
{
    public function __construct(private readonly BloodRequestService $bloodRequestService)
    {
    }

    /**
     * @OA\GET(
     *     path="/api/v1/backend/bloodrequests",
     *     tags={"Blood Requests Backend"},
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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
