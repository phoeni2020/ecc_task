<?php

namespace App\Http\Controllers;

use App\Http\Requests\PharmacyRequest;
use App\Http\Services\PharmacyService;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{
    protected $pharmacyService;

    public function __construct(PharmacyService $pharmacyService)
    {
        $this->pharmacyService = $pharmacyService;
    }

    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = 10;
        $pharmacies = $this->pharmacyService->listAllPharmacies($page, $perPage);
        return view('pharmacies.index', compact('pharmacies'));
    }


    public function create()
    {
        return view('pharmacies.form');
    }

    public function store(PharmacyRequest $request)
    {
        try
        {
            $this->pharmacyService->createPharmacy($request);
            if($request->type == 'web')
                return redirect()->route('pharmacies.index')->with('success', 'Pharmacy created successfully.');

            return response()->json($pharmacy, 201);

        }
        catch (\Exception $exception)
        {
            if(config('app.debug'))
            {
                if($request->type == 'web')
                    return redirect()->back()->with('error', $exception->getMessage());

                return response()->json($exception, 500);
            }
        }
    }

    public function show($id)
    {
        $pharmacy = $this->pharmacyService->findPharmacyById($id);
        return view('pharmacies.show', compact('pharmacy'));
    }

    public function edit($id)
    {
        $pharmacy = $this->pharmacyService->findPharmacyById($id);
        return view('pharmacies.form', compact('pharmacy'));
    }

    public function update(PharmacyRequest $request, $id)
    {

        $this->pharmacyService->updatePharmacy($id, $request);
        return redirect()->route('pharmacies.index')->with('success', 'Pharmacy updated successfully.');
    }

    public function destroy($id)
    {
        $this->pharmacyService->deletePharmacy($id);
        return redirect()->route('pharmacies.index')->with('success', 'Pharmacy deleted successfully.');
    }
}
