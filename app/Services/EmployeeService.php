<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\EmployeeRepository;

class EmployeeService extends CrudService
{
    public function __construct(private readonly EmployeeRepository $employeeRepository)
    {
        parent::__construct(
            $employeeRepository,
            fn() => __('Employee not found.')
        );
    }
}
