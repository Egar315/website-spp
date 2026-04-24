<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SppSetting extends Model
{
    protected $fillable = [
        'grade_level',
        'monthly_fee',
        'late_penalty',
        'payment_deadline',
    ];
}
