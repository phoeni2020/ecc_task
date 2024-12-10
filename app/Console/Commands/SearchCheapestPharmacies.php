<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Pharmacy;
use Illuminate\Support\Facades\Log;

class SearchCheapestPharmacies extends Command
{
    // Define the name and signature of the console command.
    protected $signature = 'products:search-cheapest {productId}';

    // The console command description.
    protected $description = 'Return the cheapest 5 pharmacies for a given product ID';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $productId = $this->argument('productId');

        // Find the product and handle the scenario where it doesn't exist
        $product = $this->getProductById($productId);
        if (!$product) {
            return;
        }

        // Get the cheapest pharmacies and output the result in JSON format
        $cheapestPharmacies = $this->getCheapestPharmacies($product);

        if ($cheapestPharmacies->isEmpty()) {
            $this->info("No pharmacies found for the given product.");
            return;
        }

        $this->line($cheapestPharmacies->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * Retrieve the product by its ID.
     *
     * @param int $productId
     * @return Product|null
     */
    private function getProductById(int $productId): ?Product
    {
        $product = Product::find($productId);
        if (!$product) {
            $this->error("Product with ID {$productId} not found.");
        }
        return $product;
    }

    /**
     * Retrieve the cheapest pharmacies for a product.
     *
     * @param Product $product
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getCheapestPharmacies(Product $product)
    {
        return $product->pharmacies()
            ->orderBy('product_pharmacy.price', 'asc')
            ->take(5)
            ->get(['pharmacies.id', 'pharmacies.name', 'product_pharmacy.price as price']);
    }
}
