<?php

namespace App\Repositories;

use App\Http\Requests\PharmacyRequest;
use App\Models\Pharmacy;
use App\interfaces\PharmacyRepositoryInterface;

class PharmacyRepository implements PharmacyRepositoryInterface
{
    public function all()
    {
        return Pharmacy::all();
    }

    public function findById($id)
    {
        return Pharmacy::findOrFail($id);
    }

    public function create(PharmacyRequest $data)
    {
        return Pharmacy::create($data->validated());
    }

    public function update($id, PharmacyRequest $data)
    {
        $pharmacy = Pharmacy::findOrFail($id);
        $pharmacy->update($data->validated());
        return $pharmacy;
    }

    public function delete($id)
    {
        return Pharmacy::destroy($id);
    }

    public function paginate($perPage = 10)
    {
        return Pharmacy::paginate($perPage);
    }

}
