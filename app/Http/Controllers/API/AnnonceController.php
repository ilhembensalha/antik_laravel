<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use Illuminate\Http\Request;

class AnnonceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $annonces = Annonce::all();
        if ($annonces) {
            return response()->json([
                'status' => 200,
                'annonces' => $annonces
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Aucune annonces trouvé',
            ]);
        }
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required',
            'description' => 'required',
            'image' => 'required',
            'date' => 'required',
            'prix' => 'required',
            'statut' => 'required',
            'location' => 'required',
            'nbr_vu' => 'required',
            'cat_id' => 'required'
        ]);
    
        $annonce = Annonce::create($request->all());
        return response()->json($annonce, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Annonce  $annonce
     * @return \Illuminate\Http\Response
     */
    public function show(Annonce $annonce)
    {
        return response()->json($annonce, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Annonce  $annonce
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Annonce $annonce)
    {
        $request->validate([
            'titre' => 'required',
            'description' => 'required',
            'image' => 'required',
            'date' => 'required',
            'prix' => 'required',
            'statut' => 'required',
            'location' => 'required',
            'nbr_vu' => 'required',
            'cat_id' => 'required'
        ]);
    
        $annonce->update($request->all());
        return response()->json($annonce, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Annonce  $annonce
     * @return \Illuminate\Http\Response
     */
    public function destroy(Annonce $annonce)
    {
        $annonce->delete();
    return response()->json(['message' => 'Annonce deleted'], 204);
    }
}
