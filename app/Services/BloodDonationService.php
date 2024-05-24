<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\BloodDonationRepository;

class BloodDonationService extends CrudService
{
    public function __construct(private readonly BloodDonationRepository $bloodDonationRepository)
    {
        parent::__construct(
            $bloodDonationRepository,
            fn() => __('Blood donation not found.')
        );
    }
}