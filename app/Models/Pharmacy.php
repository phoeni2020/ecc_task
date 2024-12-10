<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address'];

    /**
     * Define the m 2 m relation with products
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_pharmacy')
            ->withPivot('price');
    }
}
