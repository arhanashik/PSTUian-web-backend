<?php

namespace Database\Seeders;

use App\Services\DonationService;
use Illuminate\Database\Seeder;

class DonationsSeeder extends Seeder
{
    public function __construct(private readonly DonationService $donationService)
    {
    }

    public function run(): void
    {
        $this->donationService->createDonation([
            'name' => 'John Doe',
            'info' => 'Donation for the cause',
            'email' => 'test@example.com',
            'reference' => '123456',
            'confirmed' => false,
            'deleted' => false,
        ]);
    }
}
