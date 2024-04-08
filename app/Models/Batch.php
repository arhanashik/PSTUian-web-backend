<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;
    protected $fillable = [
        'faculty_id',
        'name',
        'title',
        'academicyear_id',
        'total_student',
        'deleted'
    ];
}
