<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;

use App\Http\Controllers\Controller;


class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::all();
        return view('categories.index', ['categories' => $categories]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomcat' => 'required|string|max:255',
        ]);

        Categorie::create([
            'nomcat' => $request->nomcat,
            // Add other fields if needed
        ]);

        return redirect()->route('categories.index')->with('success', 'Categorie added successfully');
    }

    public function edit($id)
    {
        $categorie = Categorie::find($id);

        if ($categorie) {
            return view('categories.edit', ['Categorie' => $categorie]);
        }

        return redirect()->route('categories.index')->with('error', 'Categorie not found');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomcat' => 'required|string|max:255',
        ]);

        $categorie = Categorie::find($id);

        if ($categorie) {
            $categorie->update([
                'nomcat' => $request->nomcat,
                // Update other fields if needed
            ]);

            return redirect()->route('categories.index')->with('success', 'Categorie updated successfully');
        }

        return redirect()->route('categories.index')->with('error', 'Categorie not found');
    }

    public function destroy($id)
    {
        $categorie = Categorie::find($id);

        if ($categorie) {
            $categorie->delete();

            return redirect()->route('categories.index')->with('success', 'Categorie deleted successfully');
        }

        return redirect()->route('categories.index')->with('error', 'Categorie not found');
    }
}
