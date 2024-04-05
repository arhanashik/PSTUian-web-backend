<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enum\DeleteStatus;
use App\Models\Batch;

class BatchRepository extends CrudRepository
{
    protected string $model = Batch::class;
}
