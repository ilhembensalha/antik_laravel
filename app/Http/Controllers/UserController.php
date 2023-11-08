<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

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
            // Valider les données du formulaire
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ]);
    
            // Enregistrer le nouvel utilisateur
            User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ]);
    
            return redirect('/users')->with('success', 'Utilisateur créé avec succès.');
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
    
        public function update(Request $request, $id)
        {
            // Valider les données du formulaire
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
            ]);
    
            // Mettre à jour l'utilisateur
            $user = User::find($id);
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->save();
    
            return redirect('/users')->with('success', 'Utilisateur mis à jour avec succès.');
        }
    
        public function destroy($id)
        {
            // Supprimer l'utilisateur
            $user = User::find($id);
            $user->delete();
    
            return redirect('/users')->with('success', 'Utilisateur supprimé avec succès.');
        }
    
    
}
