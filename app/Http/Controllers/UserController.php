<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
   
        public function index()
        {
            $users = User::all();
            return view('users.index', ['users' => $users]);
        }
    
        public function create()
        {
            return view('users.create');
        }
        public function store(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ]);
        
            User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);
        
            return redirect()->route('users.index')->with('success', 'User added successfully');
        }
        
    
        public function show($id)
        {
            $user = User::find($id);
            return view('users.show', ['user' => $user]);
        }
    
        public function edit($id)
        {
            $user = User::find($id);
            return view('users.edit', ['user' => $user]);
        }
    
       /* public function update(Request $request, User $user)
        {
            // Validate the request data here, if necessary
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
            ]);
        
            // Update the user's information
            $user->update($validatedData);
        
            // Redirect to a success page or return a response
            return redirect()->route('users.index')->with('success', 'User updated successfully');
        }*/
        public function update(Request $request, $id)
        {
          $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,',
          ]);
          $user = User::find($id);
          $user->update($request->all());
          return redirect()->route('users.index')
            ->with('success', 'user updated successfully.');
        }
    
        public function destroy($id)
        {
            // Supprimer l'utilisateur
            $user = User::find($id);
            $user->delete();
    
            return redirect('/users')->with('success', 'Utilisateur supprimé avec succès.');
        }
    
    
}
