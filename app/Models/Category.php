<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'description'];

    // public function stores()
    // {
    //     return $this->belongsToMany(Store::class, 'store_categories');
    // }

    public function stores()
{
    return $this->belongsToMany(Store::class, 'store_categories', 'category_id', 'store_id');
}
}