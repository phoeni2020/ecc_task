<?php

namespace App\Http\Services;

use App\Http\Requests\PharmacyRequest;
use App\interfaces\PharmacyRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class PharmacyService
{
    protected $pharmacyRepository;

    public function __construct(PharmacyRepositoryInterface $pharmacyRepository)
    {
        $this->pharmacyRepository = $pharmacyRepository;
    }

    public function listAllPharmacies($page = 1, $perPage = 10)
    {
        $cacheKey = "pharmacies_page_{$page}_perpage_{$perPage}";

        return Cache::remember($cacheKey, 3600, function () use ($perPage) {
            return $this->pharmacyRepository->paginate($perPage);
        });
        //dd(Cache::get($cacheKey));
    }


    public function findPharmacyById($id)
    {
        return Cache::remember("pharmacy_{$id}", 3600, function () use ($id) {
            return $this->pharmacyRepository->findById($id);
        });
    }

    public function createPharmacy(PharmacyRequest $data)
    {
        $pharmacy = $this->pharmacyRepository->create($data);
        Cache::forget('pharmacies_list'); // Invalidate the cache
        return $pharmacy;
    }

    public function updatePharmacy($id, PharmacyRequest $data)
    {
        $pharmacy = $this->pharmacyRepository->update($id, $data);
        Cache::forget("pharmacy_{$id}");
        Cache::forget('pharmacies_list');
        return $pharmacy;
    }

    public function deletePharmacy($id)
    {
        $result = $this->pharmacyRepository->delete($id);
        Cache::forget("pharmacy_{$id}");
        Cache::forget('pharmacies_list');
        return $result;
    }
}
