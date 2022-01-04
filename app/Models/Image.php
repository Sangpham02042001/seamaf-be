<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    
    protected $fillable = [
        "path",
        "product_id"
    ];

    public function product() {
        return $this->belongsTo('App\Models\Product');
    }
}
