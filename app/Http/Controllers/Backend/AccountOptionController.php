<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Exception;
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
