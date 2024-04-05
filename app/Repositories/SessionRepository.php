<?php 

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Session;
use App\Repositories\CrudRepository; 

class SessionRepository extends CrudRepository{
    protected string $model = Session::class;
}