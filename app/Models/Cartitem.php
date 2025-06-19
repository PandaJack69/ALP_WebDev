<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cartitem extends Model
{
    use HasFactory;

    protected $table = 'cart_items';

    protected $fillable = ['cart_id', 'item_id', 'day_of_week', 'quantity'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}