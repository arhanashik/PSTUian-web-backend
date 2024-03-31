<?php 

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Faculty;

class FacultyRepository extends CrudRepository{

    protected string $model = Faculty::class;
    
}