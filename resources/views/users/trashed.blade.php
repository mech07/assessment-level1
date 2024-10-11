@extends('layouts.app')

@section('title', 'Trashed Users')

@section('content')
<div class="container">
    <h1>Trashed Users</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($trashedUsers->isEmpty())
        <p>No trashed users found.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Deleted At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trashedUsers as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->deleted_at->format('M d, Y h:i A') }}</td>
                    <td>
                        <!-- Restore button -->
                        <form action="{{ route('users.restore', $user->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success">Restore</button>
                        </form>

                        <!-- Permanently Delete button -->
                        <form action="{{ route('users.forceDelete', $user->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to permanently delete this user?');">
                                Permanently Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('users.index') }}" class="btn btn-primary">Back to Users List</a>
</div>
@endsection
