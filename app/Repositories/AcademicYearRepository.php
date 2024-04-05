<?php 

declare(strict_types=1);

namespace App\Repositories;

use App\Models\AcademicYear;
use App\Repositories\CrudRepository; 

class AcademicYearRepository extends CrudRepository{
    protected string $model = AcademicYear::class;
}