<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Donation;
use App\Repositories\DonationRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DonationService
{
    const DONATION_NOT_FOUND_MESSAGE = 'Donation not found.';

    public function __construct(
        private readonly DonationRepository $donationRepository
    ) {
    }

    public function createDonation(array $data): Donation
    {
        return $this->donationRepository->create($data);
    }

    public function updateDonation(int $id, array $data): void
    {
        $donation = $this->donationRepository->find($id);

        if (!$donation) {
            throw new NotFoundHttpException(__(self::DONATION_NOT_FOUND_MESSAGE));
        }

        $this->donationRepository->update($donation, $data);
    }

    public function deleteDonation(int $id): void
    {
        $donation = $this->donationRepository->find($id);

        if (!$donation) {
            throw new NotFoundHttpException(__(self::DONATION_NOT_FOUND_MESSAGE));
        }

        $this->donationRepository->delete($donation);
    }

    public function getDonations(): array
    {
        return $this->donationRepository->all();
    }

    public function getPaginatedDonations(?int $perPage = null, $filters = []): array
    {
        return $this->donationRepository->paginate($perPage, $filters);
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