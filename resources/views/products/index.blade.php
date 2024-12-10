@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-3 text-center">Product List</h1>

        <!-- Search Bar -->
        <div class="mb-3 position-relative">
            <input
                    type="text"
                    id="search"
                    class="form-control"
                    placeholder="Search for a product..."
            />
            <div id="suggestions-box" class="dropdown-menu position-absolute bg-white border mt-1" style="display:none;"></div>
        </div>

        <!-- Product Table -->
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Price ($)</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($products as $product)
                        <tr class="product-row" data-url="{{ route('products.show', $product->id) }}">
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->title }}</td>
                            <td>{{ $product->description ?? 'N/A' }}</td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No products found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-3 d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    </div>
@endsection
