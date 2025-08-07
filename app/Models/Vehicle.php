<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'image',
        'price',
        'details',
        'brand',
        'model',
        'year',
        'mileage',
        'color',
        'fuel',
        'transmission',
        'seats',
        'status' // pending, approved, rejected
    ];

     public function user()
    {
        return $this->belongsTo(User::class);
    }
}