<?php 

declare(strict_types=1);

namespace App\Repositories;

use App\Models\BloodDonationRequset;
use App\Repositories\CrudRepository; 

class BloodRequestRepository extends CrudRepository{
    protected string $model = BloodDonationRequset::class;
}