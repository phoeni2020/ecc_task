@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Product Title -->
        <div class="text-center mb-3">
            <h1>{{ $product->title }}</h1>
            <p class="text-muted">{{ $product->description ?? 'No description available.' }}</p>
        </div>

        <!-- Pharmacies Table -->
        <div class="card">
            <div class="card-header">
                <h4 class="text-center">Available at Pharmacies</h4>
            </div>
            <div class="card-body">
                @if($product->pharmacies->isEmpty())
                    <p class="text-muted text-center">No pharmacies found for this product.</p>
                @else
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Pharmacy Name</th>
                            <th>Address</th>
                            <th>Price ($)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($product->pharmacies as $pharmacy)
                            <tr>
                                <td>{{ $pharmacy->name }}</td>
                                <td>{{ $pharmacy->address }}</td>
                                <td>${{ number_format($pharmacy->pivot->price, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <div class="mt-3 text-center">
            <a href="{{ route('products.index') }}" class="btn btn-primary">Back to Products</a>
        </div>
    </div>
@endsection
