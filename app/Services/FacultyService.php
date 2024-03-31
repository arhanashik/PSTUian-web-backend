<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\FacultyRepository;

class FacultyService{

    const NOT_FOUND_MESSAGE = "Faculty not found";

    private readonly FacultyRepository $facultyRepository;
    
    public function __construct(FacultyRepository $facultyRepositoryInstance) {
        $this->facultyRepository = $facultyRepositoryInstance;
    } 
    
}