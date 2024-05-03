<?php 

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Teacher;
use App\Repositories\CrudRepository; 

class TeacherRepository extends CrudRepository{
    protected string $model = Teacher::class;
}