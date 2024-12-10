<?php

namespace App\Http\services;

use App\Http\Requests\ProductRequest;
use App\interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Handle busines logic related to products
 */
class ProductService
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * ProductService constructor.
     *
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * List all products with pagination.
     *
     * @param int $page
     * @param int $perPage
     * @return mixed
     */
    public function listAllProducts(int $page = 1, int $perPage = 10)
    {
        // Generate a cache key based on the page and perPage
        $cacheKey = $this->getCacheKeyForPagination($page, $perPage);

        // Check if the cache exists and return it, else query the repository and store the result in cache
        $products = Cache::remember($cacheKey, 3600, function () use ($perPage) {
            return $this->productRepository->paginate($perPage);
        });

        return $products;
    }

    /**
     * Find a product by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function findProductById(int $id)
    {
        $cacheKey = $this->getCacheKeyForProduct($id);

        return Cache::remember($cacheKey, 3600, function () use ($id) {
            return $this->productRepository->findById($id);
        });
    }

    /**
     * Create a new product.
     *
     * @param ProductRequest $data
     * @return mixed
     * @throws Exception
     */
    public function createProduct(ProductRequest $data)
    {
        try {
            $product = $this->productRepository->create($data);
            $this->clearCache();
            return $product;
        } catch (Exception $e) {
            throw new Exception("Error creating product: " . $e->getMessage());
        }
    }

    /**
     * Update an existing product.
     *
     * @param int $id
     * @param ProductRequest $data
     * @return mixed
     * @throws Exception
     */
    public function updateProduct(int $id, ProductRequest $data)
    {
        try {
            $product = $this->productRepository->update($id, $data);
            $this->clearCache($id);
            return $product;
        } catch (Exception $e) {
            throw new Exception("Error updating product: " . $e->getMessage());
        }
    }

    /**
     * Delete a product.
     *
     * @param int $id
     * @return mixed
     * @throws Exception
     */
    public function deleteProduct(int $id)
    {
        try {
            $result = $this->productRepository->delete($id);
            $this->clearCache($id);
            return $result;
        } catch (Exception $e) {
            throw new Exception("Error deleting product: " . $e->getMessage());
        }
    }

    /**
     * Search products by name.
     *
     * @param string $name
     * @return mixed
     */
    public function searchProducts(string $name)
    {
        $cacheKey = $this->getCacheKeyForProductSearch($name);

        return Cache::remember($cacheKey, 3600, function () use ($name) {
            return $this->productRepository->searchByName($name);
        });
    }

    /**
     * Helper to get cache key for pagination.
     *
     * @param int $page
     * @param int $perPage
     * @return string
     */
    private function getCacheKeyForPagination(int $page, int $perPage): string
    {
        return "products_page_{$page}_perpage_{$perPage}";
    }

    /**
     * Helper to get cache key for a specific product.
     *
     * @param int $id
     * @return string
     */
    private function getCacheKeyForProduct(int $id): string
    {
        return "product_{$id}";
    }

    /**
     * Helper to get cache key for product search.
     *
     * @param string $name
     * @return string
     */
    private function getCacheKeyForProductSearch(string $name): string
    {
        return "product_search_{$name}";
    }

    private function clearCache(int $productId = null)
    {
        // Clear specific product cache if productId is provided
        if ($productId) {
            Cache::forget("product_{$productId}");
        }

        // Clear all product list cache (pagination cache)
        Cache::forget('products_list'); // TODO: consider using a more specific key for cache invalidation

        // Clear all paginated cache keys for all pages
        $this->clearPaginationCache();
    }

    private function clearPaginationCache()
    {
        //TODO: store all cache keys for pagination invalidation
        // This example assumes that i may know all pagination keys, but i might want a more flexible approach

        // Example of clearing cache for pages 1-10
        for ($page = 1; $page <= 10; $page++) {
            Cache::forget("products_page_{$page}_perpage_10");
        }
    }



}
