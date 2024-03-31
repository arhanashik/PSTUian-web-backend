<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountsOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_option',
    ];
}
