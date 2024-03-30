<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Traits\Responsable;

abstract class BaseController extends Controller
{
    use Responsable;
}
