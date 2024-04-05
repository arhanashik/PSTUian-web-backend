<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\AcademicYear;
use App\Repositories\AcademicYearRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AcademicYearService extends CrudService
{
    const NOT_FOUND_MESSAGE = "AcademicYear not found";

    public function __construct(private readonly AcademicYearRepository $academicYearRepository)
    {
        parent::__construct(
            $academicYearRepository,
            fn() => __('Academic-Year not found.')
        );
    }
}