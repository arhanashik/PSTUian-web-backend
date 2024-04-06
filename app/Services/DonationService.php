<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Donation;
use App\Repositories\DonationRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DonationService extends CrudService
{
    const DONATION_NOT_FOUND_MESSAGE = 'Donation not found.';

    public function __construct(private readonly DonationRepository $donationRepository)
    {
        parent::__construct(
            $donationRepository,
            fn() => __(self::DONATION_NOT_FOUND_MESSAGE)
        );
    }

    public function confirmDonation(string $reference): Donation
    {
        $donation = $this->donationRepository->findByReference($reference);

        if (!$donation) {
            throw new NotFoundHttpException(__(self::DONATION_NOT_FOUND_MESSAGE));
        }

        return $this->donationRepository->confirm($donation);
    }

    public function unconfirmDonation(string $reference): Donation
    {
        $donation = $this->donationRepository->findByReference($reference);

        if (!$donation) {
            throw new NotFoundHttpException(self::DONATION_NOT_FOUND_MESSAGE);
        }

        return $this->donationRepository->unconfirm($donation);
    }
}