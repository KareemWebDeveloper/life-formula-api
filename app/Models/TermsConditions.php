<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermsConditions extends Model
{
    use HasFactory;
    protected $fillable = [
        'terms_conditions',
        'privacy_policy',
        'shipping_policies',
        'returns_policies',
    ];
}
