<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\CourseRepository;

class CourseService extends CrudService
{
    public function __construct(private readonly CourseRepository $courseRepository)
    {
        parent::__construct(
            $courseRepository,
            fn() => __('Course not found.')
        );
    }
}