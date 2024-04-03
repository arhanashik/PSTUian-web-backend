<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'reg',
        'phone',
        'linked_in',
        'blood',
        'address',
        'email',
        'batch_id',
        'session_id',
        'faculty_id',
        'fb_link',
        'image_url',
        'cv_link',
        'password',
        'bio',
        'deleted'
    ];
}
