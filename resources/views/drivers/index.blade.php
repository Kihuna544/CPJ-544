@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Drivers</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('drivers.create') }}" class="btn btn-primary">Add Driver</a>
    </div>

    @if($drivers->count())
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>License Number</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($drivers as $driver)
                    <tr>
                        <td>{{ $driver->name }}</td>
                        <td>{{ $driver->phone }}</td>
                        <td>{{ $driver->license_number }}</td>
                        <td class="text-center">
                            <form action="{{ route('drivers.destroy', $driver->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this driver?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $drivers->links() }}
        </div>
    @else
        <div class="alert alert-info">No drivers found. Add one using the button above.</div>
    @endif
</div>
@endsection
