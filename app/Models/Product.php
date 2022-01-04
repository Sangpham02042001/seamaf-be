<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        "description",
        "price",
        "category_id",
        "is_top",
        "on_sale"
    ];
    use HasFactory;

    protected $primaryKey = 'id';

    public function images() {
        return $this->hasMany('App\Models\Image');
    }

    public function category() {
        return $this->belongsTo('App\Models\Category');
    }
}
