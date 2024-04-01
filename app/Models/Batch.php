<?php

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
        'session',
        'total_student',
        'deleted'
    ];
}