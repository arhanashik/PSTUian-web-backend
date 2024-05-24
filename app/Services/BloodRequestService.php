<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\BloodRequestRepository;

class BloodRequestService extends CrudService
{
    public function __construct(private readonly BloodRequestRepository $bloodRequestRepository)
    {
        parent::__construct(
            $bloodRequestRepository,
            fn() => __('Blood request not found.')
        );
    }
}