<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Batch;
use App\Repositories\BatchRepository;

class BatchService
{
    const NOT_FOUND_MESSAGE = 'Batch not found.';

    public function __construct(
        private readonly BatchRepository $batchRepository
    ) {
    }

    public function getBatches(): array
    {
        return $this->batchRepository->all();
    }

    public function getPaginatedBatches(?int $perPage = null, $filters = []): array
    {
        $filters['deleted'] = 0;
        return $this->batchRepository->paginate($perPage, $filters);
    }

    public function getBatch(int $id)
    {
        return $this->batchRepository->find($id);
    }

    public function storeBatch(array $data): Batch
    {
        return $this->batchRepository->create($data);
    }

    public function updateBatch(int $id, array $data): Batch
    {
        $batch = $this->batchRepository->find($id);

        if (!$batch) {
            throw new NotFoundHttpException(__(self::NOT_FOUND_MESSAGE));
        }

        return $this->batchRepository->update($batch, $data);
    }

    public function deleteBatch(int $id): Batch
    {
        $batch = $this->batchRepository->find($id);

        if (!$batch) {
            throw new NotFoundHttpException(__(self::NOT_FOUND_MESSAGE));
        }

        return $this->batchRepository->deleteBatch($batch);
    }
}
