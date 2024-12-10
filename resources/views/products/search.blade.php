@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-3 text-center">Search Products</h1>

        <!-- Search Bar -->
        <form action="{{ route('products.search') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="query" class="form-control" placeholder="Search for a product..." value="{{ $query }}">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>

        <!-- Results Section -->
        @if($query)
            <h4>Results for "{{ $query }}"</h4>
        @endif

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>
            </thead>
            <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->title }}</td>
                    <td>{{ $product->description }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->quantity }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No results found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-3 d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    </div>
@endsection
