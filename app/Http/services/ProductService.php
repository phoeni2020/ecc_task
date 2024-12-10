<?php

namespace App\Http\Services;

use App\Http\Requests\ProductRequest;
use App\interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function listAllProducts($page = 1, $perPage = 10)
    {
        $cacheKey = "products_page_{$page}_perpage_{$perPage}";

        return Cache::remember($cacheKey, 3600, function () use ($perPage) {
            return $this->productRepository->paginate($perPage);
        });
    }


    public function findProductById($id)
    {
        return Cache::remember("product_{$id}", 3600, function () use ($id) {
            return $this->productRepository->findById($id);
        });
    }

    public function createProduct(ProductRequest $data)
    {
        $product = $this->productRepository->create($data);
        Cache::forget('products_list'); // Invalidate the cache
        return $product;
    }

    public function updateProduct($id, ProductRequest $data)
    {
        $product = $this->productRepository->update($id, $data);
        Cache::forget("product_{$id}");
        Cache::forget('products_list');
        return $product;
    }

    public function deleteProduct($id)
    {
        $result = $this->productRepository->delete($id);
        Cache::forget("product_{$id}");
        Cache::forget('products_list');
        return $result;
    }

    public function searchProducts($name)
    {

        return Cache::remember("product_search_{$name}", 3600, function () use ($name) {
            return $this->productRepository->searchByName($name);
        });
    }
}
