<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chartofaccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'account_code',
        'account_title',
        'remarks'
    ];
}
