<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enum\DeleteStatus;

class CrudRepository
{
    /**
     * Number of items per page.
     *
     * @var int
     */
    public const PER_PAGE = 20;

    public function all($filters = []): array
    {
        if (empty($filters)) {
            return $this->model::all()->toArray();
        }

        return $this->model::where($filters)->get()->toArray();
    }

    public function paginate(?int $perPage = null, $filters = []): array
    {
        $perPage = $perPage ?? self::PER_PAGE;

        if (empty($filters)) {
            return $this->model::paginate($perPage)->toArray();
        }

        return $this->model::where($filters)->paginate($perPage)->toArray();
    }

    /**
     * Modal class name.
     *
     * @var string
     */
    protected string $model;

    public function create(array $data): object
    {
        return $this->model::create($data);
    }

    public function update(object $model, array $data): object
    {
        $model->update($data);

        return $model;
    }

    public function delete(object $model): object
    {
        $model->delete();

        return $model;
    }

    public function find(int $id): ?object
    {
        return $this->model::find($id);
    }

    public function findByColumn(string $column, string $value): ?object
    {
        return $this->model::where($column, $value)->first();
    }

    public function softDelete(object $model): ?object
    {
        $model->update(['deleted' => DeleteStatus::SOFT_DELETE]);

        return $model;
    }

    public function hardDelete(object $model): ?object
    {
        $model->update(['deleted' => DeleteStatus::HARD_DELETE]);

        return $model;
    }
}
