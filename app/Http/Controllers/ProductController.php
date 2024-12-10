<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Services\ProductService;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        /*Cache::put('test_key', 'test_value', 10);
        dd(Cache::get('test_key'));*/
        $page = $request->get('page', 1);
        $perPage = 10;
        $products = $this->productService->listAllProducts($page, $perPage);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.form');
    }

    public function store(ProductRequesto $request)
    {
        $this->productService->createProduct($request);
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show($id)
    {
        $product = $this->productService->findProductById($id);
        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = $this->productService->findProductById($id);
        return view('products.form', compact('product'));
    }

    public function update(ProductRequest $request, $id)
    {
        $this->productService->updateProduct($id, $request);
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $this->productService->deleteProduct($id);
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->get('query', '');

        // Perform the search using a LIKE query
        $products = $this->productService->searchProducts($query);

        return view('products.search', compact('products', 'query'));
    }
    public function searchAjax(Request $request)
    {
        $query = $request->get('query', '');

        // Get products by defined fields
        /**
         * Why i used the model insted of repo
         * cause i wanted to have EZ quick accsess to test the query and modify it any time
         */
        $results = Product::where('title', 'like', "%{$query}%")
            ->limit(10)
            ->get(['id', 'title', 'description', 'price', 'quantity']);

        return response()->json($results);
    }


    public function filterProducts(Request $request)
    {
        $query = $request->get('query', '');
        $products = Product::where('title', 'like', "%{$query}%")
            ->paginate(10);

        return view('products.index', compact('products'));
    }

}
