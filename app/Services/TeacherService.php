<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\TeacherRepository;

class TeacherService extends CrudService
{
    const NOT_FOUND_MESSAGE = "Teacher not found";

    public function __construct(private readonly TeacherRepository $teacherRepository)
    {
        parent::__construct(
            $teacherRepository,
            fn() => __(self::NOT_FOUND_MESSAGE)
        );
    }
}