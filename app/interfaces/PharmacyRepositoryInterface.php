<?php

namespace App\interfaces;

use App\Http\Requests\PharmacyRequest;

interface PharmacyRepositoryInterface
{
    public function all();
    public function findById(int $id);
    public function create(PharmacyRequest $data);
    public function update(int $id, PharmacyRequest $data);
    public function delete(int $id);
}