<?php

namespace Database\Seeders;

use App\Services\AccountOptionService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountOptionSeeder extends Seeder
{
    public function __construct(private readonly AccountOptionService $accountOptionService)
    {
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->accountOptionService->createAccountOption([
            'donation_option' => 'Rocket-01403487219 (from seeder)',
        ]);
    }
}
