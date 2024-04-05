<?php 

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Student;
use App\Repositories\CrudRepository; 

class StudentRepository extends CrudRepository{
    protected string $model = Student::class;
}