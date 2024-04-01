<?php

namespace App\Repositories;

use App\Models\Batch;

class BatchRepository extends CrudRepository
{
    protected string $model = Batch::class;

    public function getAll()
    {
        return $this->getAll();
    }

    public function view(int $id): ?Batch
    {
        return $this->find($id);
    }

    public function store($data)
    {
        return $this->create($data);
    }

    public function edit(int $id, array $data)
    {
        $batch = Batch::find($id);
        return $this->update($batch, $data);
    }

    public function destroy($id)
    {
        return $this->delete($id);
    }
}
