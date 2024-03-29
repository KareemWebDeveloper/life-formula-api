<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address',
        'city',
        'state',
        'zip_code',
        'phone',
        'gender',
        'location_link',
    ];

public function user(){
    return $this->belongsTo(User::class);
}
}
