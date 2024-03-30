<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Traits\Responsable;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="PSTUian API Documentation",
 *      description="API Documentation",
 *      @OA\License(
 *         name="Apache 2.0",
 *         url="https://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */
abstract class BaseController extends Controller
{
    use Responsable;
}
