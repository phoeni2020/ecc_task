@extends('layouts.app')

@section('content')
    <h1>{{ isset($pharmacy) ? 'Edit Pharmacy' : 'Add Pharmacy' }}</h1>

    <form action="{{ isset($pharmacy) ? route('pharmacies.update', $pharmacy->id) : route('pharmacies.store') }}" method="POST">
        @csrf
        @if(isset($pharmacy)) @method('PUT') @endif

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" value="{{ $pharmacy->name ?? '' }}" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" name="address" value="{{ $pharmacy->address ?? '' }}" required>
        </div>

        <button type="submit" class="btn btn-success">{{ isset($pharmacy) ? 'Update' : 'Add' }}</button>
    </form>
@endsection
