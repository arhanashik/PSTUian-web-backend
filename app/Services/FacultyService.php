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

    public function getFaculties(): array
    {
        return $this->facultyRepository->all();
    }

    public function getPaginatedFaculties(?int $perPage = null, $filters = []): array
    {
        return $this->facultyRepository->paginate($perPage, $filters);
    }

    public function storeFaculty(array $data): Faculty
    {
        return $this->facultyRepository->create($data);
    }

    public function updateFaculty(int $id, array $data): Faculty
    {
        $faculty = $this->facultyRepository->find($id);

        if (!$faculty) {
            throw new NotFoundHttpException(__(self::NOT_FOUND_MESSAGE));
        }

        return $this->facultyRepository->update($faculty, $data);
    }

    public function FacultyById(int $id): ?Faculty
    {
        $faculty = $this->facultyRepository->find($id);

        if (!$faculty) {
            throw new NotFoundHttpException(__(self::NOT_FOUND_MESSAGE));
        }

        return $faculty;
    }
}