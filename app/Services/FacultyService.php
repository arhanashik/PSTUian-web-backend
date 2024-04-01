<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Faculty;
use App\Repositories\FacultyRepository;

class FacultyService
{
    const NOT_FOUND_MESSAGE = "Faculty not found";

    public function __construct(
        private readonly FacultyRepository $facultyRepository
    ) {
    }
    
    public function storeFaculty(array $data): Faculty
    {
        return $this->facultyRepository->create($data);
    }
}