<?php

namespace App\Repositories;

use App\Helper\Constant;
use App\Models\Batch;

class BatchRepository extends CrudRepository
{
    protected string $model = Batch::class;

    public function deleteBatch($batch): Batch
    {
        $batch->update(['deleted' => Constant::SOFT_DELETE]);
        return $batch;
    }
}
