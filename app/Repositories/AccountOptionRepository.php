<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\AccountsOption;

class AccountOptionRepository extends CrudRepository
{
    protected string $model = AccountsOption::class;
}
