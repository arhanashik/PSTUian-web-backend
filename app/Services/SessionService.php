<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Session;
use App\Repositories\SessionRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SessionService extends CrudService
{
    const NOT_FOUND_MESSAGE = "Session not found";

    public function __construct(private readonly SessionRepository $sessionRepository)
    {
        parent::__construct(
            $sessionRepository,
            fn() => __('Session not found.')
        );
    }
}