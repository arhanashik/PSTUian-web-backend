<?php

namespace Database\Seeders;

use App\Services\AcademicYearService;
use Illuminate\Database\Seeder;

class AcademicYearSeeder extends Seeder
{
    public function __construct(private readonly AcademicYearService $academicYearService)
    {
    }
    
    public function run(): void
    {
        $this->academicYearService->create([
            'name' => '2018-2019',
        ]);
    }
}
