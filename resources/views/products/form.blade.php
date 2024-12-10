@extends('layouts.app')

@section('content')
    <h1>{{ isset($product) ? 'Edit Product' : 'Add Product' }}</h1>

    <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" method="POST">
        @csrf
        @if(isset($product))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" value="{{ $product->title ?? '' }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" rows="3" required>{{ $product->description ?? '' }}</textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" class="form-control" name="price" value="{{ $product->price ?? '' }}" required>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" name="quantity" value="{{ $product->quantity ?? '' }}" required>
        </div>

        <button type="submit" class="btn btn-success">{{ isset($product) ? 'Update' : 'Add' }}</button>
    </form>
@endsection
