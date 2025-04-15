@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-bold mb-4">Edit Journey</h1>

    <form action="{{ route('journeys.update', $journey) }}" method="POST">
        @csrf
        @method('PUT')

        <p><strong>Type:</strong> {{ $journey->type }}</p>

        <label>Status:</label>
        <select name="status" class="block w-full mb-2">
            <option value="pending" {{ $journey->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="in_progress" {{ $journey->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="completed" {{ $journey->status == 'completed' ? 'selected' : '' }}>Completed</option>
        </select>

        <button class="btn btn-primary">Update</button>
    </form>
@endsection
