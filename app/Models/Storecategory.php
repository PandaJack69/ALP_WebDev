<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storecategory extends Model
{
    use HasFactory;

    protected $table = 'store_categories';

    protected $fillable = ['store_id', 'category_id'];

    public $timestamps = false;

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}