<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\BatchRepository;

class BatchService extends CrudService
{
    public function __construct(private readonly BatchRepository $batchRepository)
    {
        parent::__construct(
            $batchRepository,
            fn() => __('Batch not found.')
        );
    }
}
