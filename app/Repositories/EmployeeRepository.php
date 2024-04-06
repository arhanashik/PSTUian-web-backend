<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Employee;

class EmployeeRepository extends CrudRepository
{
    protected string $model = Employee::class;
}
