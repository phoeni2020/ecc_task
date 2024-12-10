@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-3 text-center">Pharmacy List</h1>

        <!-- Search Bar -->
        <div class="mb-3 position-relative">
            <input
                    type="text"
                    id="search"
                    class="form-control"
                    placeholder="Search for a pharmacy"
            />
            <div id="suggestions-box" class="dropdown-menu position-absolute bg-white border mt-1" style="display:none;"></div>
        </div>

        <!-- Pharmacy Table -->
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($pharmacies as $pharmacy)
                        <tr class="pharmacy-row" data-url="{{ route('pharmacies.show', $pharmacy->id) }}">
                            <td>{{ $pharmacy->id }}</td>
                            <td>{{ $pharmacy->name }}</td>
                            <td>{{ $pharmacy->address }}</td>
                            <td>
                                <a href="{{ route('pharmacies.edit', $pharmacy->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('pharmacies.destroy', $pharmacy->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No pharmacies found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-3 d-flex justify-content-center">
            {{ $pharmacies->links() }}
        </div>
    </div>
@endsection
