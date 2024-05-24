<?php 

declare(strict_types=1);

namespace App\Repositories;

use App\Models\BloodDonation;
use App\Repositories\CrudRepository; 

class BloodDonationRepository extends CrudRepository{
    protected string $model = BloodDonation::class;
}