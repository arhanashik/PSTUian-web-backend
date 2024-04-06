<?php

namespace Database\Seeders;

use App\Services\FacultyService;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    public function __construct(private readonly FacultyService $facultyService)
    {
    }

    public function run(): void
    {
        $this->facultyService->create([
            'short_title' => 'CSE',
            'title' => 'Computer Science and Engineering'
        ]);
    }
}
