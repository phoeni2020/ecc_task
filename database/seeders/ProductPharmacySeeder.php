<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Pharmacy;

class ProductPharmacySeeder extends Seeder
{
    public function run()
    {
        // Create random products and pharmacies first
        $products = Product::factory()->count(1000)->create();
        $pharmacies = Pharmacy::factory()->count(500)->create();

        // Assign random relationships between products and pharmacies with random prices
        foreach ($products as $product) {
            $randomPharmacies = $pharmacies->random(3); // Select 3 random pharmacies for each product
            foreach ($randomPharmacies as $pharmacy) {
                $product->pharmacies()->attach($pharmacy->id, [
                    'price' => fake()->randomFloat(2, 5, 50), // Generate random float price between 5 and 50
                ]);
            }
        }
    }
}
