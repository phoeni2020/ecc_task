<?php

namespace App\interfaces;

use App\Http\Requests\PharmacyRequest;
use App\Http\Requests\ProductRequest;

interface ProductRepositoryInterface
{
    public function all();
    public function findById(int $id);
    public function create(ProductRequest $data);
    public function update($id, ProductRequest $data);
    public function delete(int $id);
    public function searchByName(string $name);
}