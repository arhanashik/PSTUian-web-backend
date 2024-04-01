<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillble =[
      'course_code',
      'course_title',
      'credit_hour',
      'faculty_id',
    ];
}