<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period_and_transmittal extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_period',
        'second_period',
        'transmittal',
        'revolving_report'
    ];

    protected $casts = [
    'first_period' => 'date',
    'second_period' => 'date',
];
}
