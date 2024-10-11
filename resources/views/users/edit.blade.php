@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="container">
    <h1>Edit User</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST" >
        @csrf
        @method('PUT') <!-- This is necessary to indicate a PUT request -->

        <div class="mb-3">
            <label for="type" class="form-label">Prefix Name</label>
            <select class="form-control" id="prefixname" name="prefixname">
                <option value="Mr" {{ old('prefixname', $user->prefixname ?? '') == 'Mr' ? 'selected' : '' }}>Mr</option>
                <option value="Mrs" {{ old('prefixname', $user->prefixname ?? '') == 'Mrs' ? 'selected' : '' }}>Mrs</option>
                <option value="Ms" {{ old('prefixname', $user->prefixname ?? '') == 'Ms' ? 'selected' : '' }}>Ms</option>
            </select>
        </div>


        <div class="mb-3">
            <label for="firstname" class="form-label">First Name</label>
            <input type="text" class="form-control" id="firstname" name="firstname" value="{{ $user->firstname }}" required>
        </div>

        <div class="mb-3">
            <label for="middlename" class="form-label">Middle Name</label>
            <input type="text" class="form-control" id="middlename" name="middlename" value="{{ $user->middlename }}">
        </div>

        <div class="mb-3">
            <label for="lastname" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="lastname" name="lastname" value="{{ $user->lastname }}" required>
        </div>

        <div class="mb-3">
            <label for="suffixname" class="form-label">Suffix Name</label>
            <input type="text" class="form-control" id="suffixname" name="suffixname" value="{{ $user->suffixname }}">
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password (Leave blank to keep current password)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>


         <div class="mb-3">
            <label for="type" class="form-label">User Type</label>
            <select class="form-control" id="type" name="type">
                <option value="admin" {{ old('type', $user->type ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ old('type', $user->type ?? '') == 'user' ? 'selected' : '' }}>User</option>
            </select>
        </div>


        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
@endsection
