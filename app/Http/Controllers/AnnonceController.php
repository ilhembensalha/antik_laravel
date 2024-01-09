<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annonce;
use App\Models\User;
use App\Models\Categorie;

use App\Http\Controllers\Controller;

class AnnonceController extends Controller
{
    //
    public function index()
    {
        $annonces = Annonce::all();
        return view('annonces.index', ['annonces' => $annonces,
        'users'=>User::all(),'categories' =>  Categorie::all()]);
    }
    
    public function show($id)
    {
        $annonce = Annonce::find($id);
        return view('annonce.show', ['annonce' => $annonce]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function accepte(Request $request, $id)
    {

        $annonce = Annonce::find($id);

        if ($annonce->accepte == 'non') {
            $annonce->accepte = 'oui';
            $annonce->update();
         return redirect('/annonces') ;
        } else if ( $annonce->accepte = 'oui'){
            returnredirect('/annonces') ;
        }

        $annonce->accepte = 'oui';
        $user->update();

        //dd($user);
        return redirect('/annonces') ;
    }
    public function destroy($id)
    {
        $annonce = Annonce::find($id);

        if ($annonce) {
            $annonce->delete();

            return redirect()->route('annonces.index')->with('success', 'annonce deleted successfully');
        }

        return redirect()->route('annonces.index')->with('error', 'annonce not found');
    }
}
