<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_name',
        'store_address',
        'description',
        'tagline'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
