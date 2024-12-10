<?php

namespace App\Repositories;

use App\Http\Requests\ProductRequest;
use App\interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function all()
    {
        return Product::all();
    }

    public function findById($id)
    {
        return Product::findOrFail($id);
    }

    public function create(ProductRequest $data)
    {
        return Product::create($data->validated());
    }

    public function update($id, ProductRequest $data)
    {
        $product = Product::findOrFail($id);
        $product->update($data->validated());
        return $product;
    }

    public function delete($id)
    {
        return Product::destroy($id);
    }

    public function searchByName($name)
    {
        return Product::where('title', 'like', "%{$name}%")->get();
    }

    public function paginate($perPage = 10)
    {
        return Product::paginate($perPage);
    }

}
