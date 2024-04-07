<?php

declare(strict_types=1);

namespace App\Services;

use App\Enum\DeleteStatus;
use App\Interface\ServiceInterface;
use App\Repositories\CrudRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class CrudService implements ServiceInterface
{
    protected $generateErrorMessage;

    /**
     * Entity Model.
     *
     * @var Model
     */
    protected $entity;

    public function __construct(
        protected CrudRepository $repository,
        callable $generateErrorMessage
    ) {
        $this->generateErrorMessage = $generateErrorMessage;
    }

    public function getById(int $id): ?object
    {
        $this->entity = $this->repository->find($id);
        if (!$this->entity) {
            $errorMessage = call_user_func($this->generateErrorMessage);
            throw new NotFoundHttpException($errorMessage);
        }
        return $this->entity;
    }

    public function getPaginatedData(?int $perPage = null, $filters = []): array
    {
        return $this->repository->paginate($perPage, $filters);
    }

    public function create(array $data): object
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): ?object
    {
        $this->entity = $this->repository->find($id);
        if (!$this->entity) {
            $errorMessage = call_user_func($this->generateErrorMessage);
            throw new NotFoundHttpException($errorMessage);
        }
        return $this->repository->update($this->entity, $data);
    }

    public function delete(int $id, int $deleteStatus): object
    {
        $this->entity = $this->repository->find($id);
        if (!$this->entity) {
            $errorMessage = call_user_func($this->generateErrorMessage);
            throw new NotFoundHttpException($errorMessage);
        }

        // Check if model has the column deleted, then do soft/hard delete.
        $hasDelete = Schema::hasColumn($this->entity->getTable(), 'deleted');

        if ($hasDelete && $deleteStatus === DeleteStatus::NOT_DELETED->value) {
            return $this->repository->revertBack($this->entity);
        }

        if ($hasDelete && $deleteStatus === DeleteStatus::SOFT_DELETE->value) {
            return $this->repository->softDelete($this->entity);
        }

        if ($hasDelete && $deleteStatus === DeleteStatus::HARD_DELETE->value) {
            return $this->repository->hardDelete($this->entity);
        }

        // Otherwise delete totally from the model.
        return $this->repository->Delete($this->entity);
    }

    public function all(): array
    {
        return $this->repository->all($filters);
    }
}