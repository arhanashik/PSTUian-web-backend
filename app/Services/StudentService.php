<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Student;
use App\Repositories\StudentRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StudentService extends CrudService
{
    const NOT_FOUND_MESSAGE = "Student not found";

    public function __construct(private readonly StudentRepository $studentRepository)
    {
        parent::__construct(
            $studentRepository,
            fn() => __('Student not found.')
        );
    }
}