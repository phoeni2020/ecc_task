<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Pharmacy;

class SearchCheapestPharmacies extends Command
{
    // The name and signature of the console command.
    protected $signature = 'products:search-cheapest {productId}';

    // The console command description.
    protected $description = 'Return the cheapest 5 pharmacies for a given product ID';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get the product ID from the argument
        $productId = $this->argument('productId');

        // Fetch the product and its pharmacies with prices
        $product = Product::find($productId);

        if (!$product) {
            $this->error("Product with ID {$productId} not found.");
            return;
        }

        // Fetch pharmacies for the product, sorted by price ascending
        $cheapestPharmacies = $product->pharmacies()
            ->orderBy('product_pharmacy.price', 'asc')  // Use 'product_pharmacy' instead of 'pivot'
            ->take(5)
            ->get(['pharmacies.id', 'pharmacies.name', 'product_pharmacy.price as price']);


        // Check if any pharmacies were found
        if ($cheapestPharmacies->isEmpty()) {
            $this->info("No pharmacies found for the given product.");
            return;
        }

        // Output the result in JSON format
        $this->line($cheapestPharmacies->toJson(JSON_PRETTY_PRINT));
    }
}
