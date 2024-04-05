<?php 

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Course;
use App\Repositories\CrudRepository; 

class CourseRepository extends CrudRepository{
    protected string $model = Course::class;
}