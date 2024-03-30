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
    ) {}


    
    /**
     * Create a new account option using the provided data.
     *
     * @param array $data The data to create the account option.
     * @return AccountsOption The created account option instance.
     */
    public function createAccountOption(array $data): AccountsOption
    {
        return $this->accountOptionRepository->create($data);
    }

}