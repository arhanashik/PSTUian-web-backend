<?php

declare(strict_types=1);

namespace App\Services;

interface ServiceInterface
{
    public function create(array $data): object;

    public function update(int $id, array $data): ?object;

    public function delete(int $id): object;

    public function getById(int $id): ?object;

    public function all(): array;
}