<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'price', 'quantity'];

    /**
     * Define the many-to-many relationship with pharmacies.
     */
    public function pharmacies()
    {
        return $this->belongsToMany(Pharmacy::class, 'product_pharmacy')
            ->withPivot('price');
    }

    /**
     * Retrieve the cheapest pharmacies for the product.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function cheapestPharmacies()
    {
        return $this->pharmacies()
            ->orderBy('product_pharmacy.price', 'asc')
            ->take(5)
            ->get(['pharmacies.id', 'pharmacies.name', 'product_pharmacy.price as price']);
    }
}
