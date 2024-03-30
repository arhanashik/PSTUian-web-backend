<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Frontend\AccountsOption;


class AccountOptionRepository extends CrudRepository
{
    /**
     * The model class associated with the repository.
     *
     * @var string
     */
    protected string $model = AccountsOption::class;
}
