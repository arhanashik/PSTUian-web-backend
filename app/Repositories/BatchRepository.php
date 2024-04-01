<?php

namespace App\Repositories;

use App\Models\Batch;

class BatchRepository extends CrudRepository
{
    protected string $model = Batch::class;

    public function deleteBatch($batch): Batch
    {
        $batch->delete();
        return $batch;
    }
}
