<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Faculty;
use App\Repositories\FacultyRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    public function updateFaculty(int $id, array $data): void
    {
        $faculty = $this->facultyRepository->find($id);

        if (!$faculty) {
            throw new NotFoundHttpException(__(self::NOT_FOUND_MESSAGE));
        }

        $this->facultyRepository->update($faculty, $data);
    }
}