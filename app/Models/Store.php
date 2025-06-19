<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'description', 'location', 'merchant_id'];

    // Relasi dengan Merchant
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    // Relasi dengan Item
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    // Relasi dengan Category
    // public function categories()
    // {
    //     return $this->belongsToMany(Category::class, 'storecategory');
    // }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'store_categories', 'store_id', 'category_id');
    }
}