<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    private function getRoles()
    {
        return [
            'admin' => 'Administrateur',
            'user' => 'Utilisateur',
        ];
    }

    public function index(): View
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function create(): View
    {
        $roles = $this->getRoles();
        return view('user.create', compact('roles'));
    }

    public function edit(User $user): View
    {
        $roles = $this->getRoles();
        return view ('user.edit', compact('user', 'roles'));   
    }

    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        
        $user->name = $request->name;
        $user->email = $request->email;
    
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password); 
        }
    
        $user->role = $request->role;
        $user->save();
        return redirect()->route('user.index');
    }

    public function store(UserRequest $request): RedirectResponse
    {

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('user.index');
    }
}
