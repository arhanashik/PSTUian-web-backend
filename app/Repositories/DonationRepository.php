<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Donation;

class DonationRepository extends CrudRepository
{
    protected string $model = Donation::class;

    public function findByReference(string $reference): ?Donation
    {
        return Donation::where('reference', $reference)->first();
    }

    public function confirm(Donation $donation): Donation
    {
        $donation->confirmed = true;
        $donation->save();

        return $donation;
    }

    public function unconfirm(Donation $donation): Donation
    {
        $donation->confirmed = false;
        $donation->save();

        return $donation;
    }
}