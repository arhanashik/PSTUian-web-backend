<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use Exception;
use App\Http\Controllers\BaseController;
use App\Http\Requests\FacultyRequest;
use App\Services\FacultyService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FacultyController extends BaseController
{
    private readonly FacultyService $facultyService;

    public function __construct(FacultyService $facultyServiceInstace)
    {
        $this->facultyService = $facultyServiceInstace;
    }
    
    public function store(FacultyRequest $facultyRequest): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->facultyService->storeFaculty($facultyRequest->all()),
                Response::HTTP_CREATED,
                __('Faculty saved successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

}
