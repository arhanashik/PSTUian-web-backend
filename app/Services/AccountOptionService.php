<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Frontend\AccountsOption;
use App\Repositories\AccountOptionRepository;

class AccountOptionService
{
    const ACCOUNT_OPTION_NOT_FOUND_MESSAGE = 'Option not found.';

    public function __construct(
        private readonly AccountOptionRepository $accountOptionRepository
    ) {

    }

    public function createAccountOption(array $data): AccountsOption
    {
        return $this->accountOptionRepository->create($data);
    }

    public function getAccountOptions(): array
    {
        return $this->accountOptionRepository->all();
    }

}