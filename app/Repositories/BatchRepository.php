<?php

namespace App\Repositories;

use App\Models\Batch;

class BatchRepository extends CrudRepository
{
    protected string $model = Batch::class;

    public function deleteBatch($batch): Batch
    {
        $batch->update(['deleted' => 1]);
        return $batch;
    }
}
