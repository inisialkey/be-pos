<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::latest();

        if (request('name')) {
            $users->where('name', 'like', '%' . request('name') . '%');
        }
        return view('pages.users.index', [
            'users' => $users->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|max:255',
            'role' => 'required|in:admin,staff,user'
        ];

        $validatedData = $request->validate($rules);
        $validatedData['password'] = Hash::make($request->password);

        User::create($validatedData);

        return redirect('/features/users')->with('success', 'New user has been added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('pages.users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if ($request->email === $user->email) {
            $rules = [
                'name' => 'required',
                'email' => 'email',
                'role' => 'required|in:admin,staff,user'
            ];
        } else {
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'role' => 'required|in:admin,staff,user'
            ];
        }
        $validatedData = $request->validate($rules);
        if ($request->password) {
            $validatedData['password'] = Hash::make($request->password);
        }

        User::where('id', $user->id)->update($validatedData);

        return redirect('/features/users')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);

        return redirect('/features/users')->with('success', 'User deleted successfully!');
    }
}
