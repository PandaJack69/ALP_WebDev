<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['user_id', 'revenue', 'joined_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // new
    public function stores()
    {
        return $this->hasMany(Store::class, 'merchant_id');
    }

    // public function stores()
    // {
    //     return $this->hasMany(Store::class);
    // }
}