<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseController;
use App\Services\FacultyService;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class FacultyController extends BaseController
{
    private readonly FacultyService $facultyService;

    public function __construct(FacultyService $facultyServiceInstace)
    {
        $this->facultyService = $facultyServiceInstace;
    }

}
