@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<div class="container">
    <h1>User Details</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">User: {{ $user->fullname }}</h5>
            <p class="card-text">
                <strong>Prefix Name:</strong> {{ $user->prefixname }} <br>
                <strong>First Name:</strong> {{ $user->firstname }} <br>
                <strong>Middle Name:</strong> {{ $user->middlename }} <br>
                <strong>Last Name:</strong> {{ $user->lastname }} <br>
                <strong>Suffix Name:</strong> {{ $user->suffixname }} <br>
                <strong>Username:</strong> {{ $user->username }} <br>
                <strong>Email:</strong> {{ $user->email }} <br>
                <strong>User Type:</strong> {{ $user->type }} <br>
                <strong>Created At:</strong> {{ $user->created_at->format('M d, Y h:i A') }} <br>
                <strong>Updated At:</strong> {{ $user->updated_at->format('M d, Y h:i A') }}
            </p>
            <a href="{{ route('users.index') }}" class="btn btn-primary">Back to List</a>
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
</div>
@endsection
