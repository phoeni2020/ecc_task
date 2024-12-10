<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'image', 'price', 'quantity'];


    public function pharmacies()
    {
        return $this->belongsToMany(Pharmacy::class, 'product_pharmacy')
            ->withPivot('price');
    }

}
