<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $fillable = [
        't_id',
        'name',
        'reg',
        'phone',
        'linkedin',
        'facebook',
        'blood',
        'address',
        'email',
        'faculty_id',
        'department_id',
        'fb_link',
        'image_url',
        'cv_link',
        'website',
        'password',
        'bio',
        'deleted'
    ];
}
