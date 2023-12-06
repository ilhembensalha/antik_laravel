<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::all();
        return response()->json($categories, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomcat' => 'required',
        ]);

        $categorie = Categorie::create($request->all());
        return response()->json($categorie, 201);
    }

    public function show($categorie)
    {
      
        $cat = Categorie::find($categorie);
        return response()->json($cat, 200);
    }


    public function update(Request $request, Categorie $categorie)
    {
        $request->validate([
            'nomcat' => 'required',
        ]);

        $categorie->update($request->all());
        return response()->json($categorie, 200);
    }

    public function destroy(Categorie $categorie)
    {
        $category->delete();
        return response()->json(['message' => 'Categorie deleted'], 204);
    }
}
