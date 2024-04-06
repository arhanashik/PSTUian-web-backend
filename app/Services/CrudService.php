<?php

declare(strict_types=1);

namespace App\Services;

use App\Interface\ServiceInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class CrudService implements ServiceInterface
{
    protected $generateErrorMessage;

    public function __construct(protected $repository, callable $generateErrorMessage)
    {
        $this->generateErrorMessage = $generateErrorMessage;
    }

    public function getById(int $id): ?object
    {
        $entity = $this->repository->find($id);
        if (!$entity) {
            $errorMessage = call_user_func($this->generateErrorMessage);
            throw new NotFoundHttpException($errorMessage);
        }
        return $entity;
    }

    public function getPaginatedDatata(?int $perPage = null, $filters = []): array
    {
        return $this->repository->paginate($perPage, $filters);
    }

    public function create(array $data): object
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): ?object
    {
        $entity = $this->repository->find($id);
        if (!$entity) {
            $errorMessage = call_user_func($this->generateErrorMessage);
            throw new NotFoundHttpException($errorMessage);
        }
        return $this->repository->update($entity, $data);
    }

    public function delete(int $id): object
    {
        $entity = $this->repository->find($id);
        if (!$entity) {
            $errorMessage = call_user_func($this->generateErrorMessage);
            throw new NotFoundHttpException($errorMessage);
        }
        return $this->repository->delete($entity);
    }

    public function forceDelete(int $id): object
    {
        $entity = $this->repository->findTrash($id);
        if (!$entity) {
            $errorMessage = call_user_func($this->generateErrorMessage);
            throw new NotFoundHttpException($errorMessage);
        }
        return $this->repository->forceDelete($entity);
    }

    public function all(): array
    {
        return $this->repository->all();
    }
}