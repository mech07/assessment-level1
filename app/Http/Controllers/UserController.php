<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Events\UserSaved;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Services\UserServiceInterface;

class UserController extends Controller
{

    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(UserRequest $request)
    {
        $attributes = $request->validated(); // This will only include validated fields
        $user = $this->userService->store($attributes);

         // Dispatch the event after the user is created
        event(new UserSaved($user));

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function index()
    {
        $users = $this->userService->list();
        return view('users.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, $id)
    {

        $attributes = $request->validated(); // Validated data for updating
        $user = $this->userService->update($id, $attributes);

         // Dispatch the event after the user is created
         event(new UserSaved($user));
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function show($id)
    {
        $user = $this->userService->find($id);
        return view('users.show', compact('user'));
    }

    public function destroy($id)
    {
        $this->userService->destroy($id); // Soft delete

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function trashed()
    {
        $trashedUsers = $this->userService->listTrashed();
        return view('users.trashed', compact('trashedUsers'));
    }

    public function restore($id)
    {
        $this->userService->restore($id);
        return redirect()->route('users.index')->with('success', 'User restored successfully.');
    }

    public function forceDelete($id)
    {
        $this->userService->delete($id); // Permanently delete the user
        return redirect()->route('users.trashed')->with('success', 'User permanently deleted.');
    }





}
