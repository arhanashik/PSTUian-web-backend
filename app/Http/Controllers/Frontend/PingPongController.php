<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use Illuminate\Http\JsonResponse;

class PingPongController extends BaseController
{
    public function index(): JsonResponse
    {
        return $this->responseJson(['ping' => 'pong']);
    }
}
