<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        's_id',
        'reg',
        'name',
        'email',
        'phone',
        'linkedin',
        'facebook',
        'blood',
        'address',
        'batche_id',
        'academicyear_id',
        'faculty_id',
        'fb_link',
        'image_url',
        'cv_link',
        'password',
        'bio',
        'deleted'
    ];
}
