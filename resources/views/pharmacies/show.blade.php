@extends('layouts.app')

@section('content')
    <h1>{{ $pharmacy->name }}</h1>
    <p><strong>Address:</strong> {{ $pharmacy->address }}</p>

    <a href="{{ route('pharmacies.index') }}" class="btn btn-primary">Back to Pharmacies</a>
@endsection
