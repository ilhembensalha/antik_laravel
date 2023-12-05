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
    $accepte = "oui"; // Replace this with your actual value

    $annonces = Annonce::where('accepte', $accepte)->get();

    if ($annonces->isEmpty()) {
        return response()->json([
            'status' => 404,
            'message' => 'Aucune annonce trouvée',
        ]);
    }

    // Transform each annonce to include image details
    $formattedAnnonces = $annonces->map(function ($annonce) {
        return [
            'id' => $annonce->id,
            'titre' => $annonce->titre,
            'description' => $annonce->description,
            'prix' => $annonce->prix,
            'location' => $annonce->location,
            'cat_id' => $annonce->cat_id,
            'user_id' => $annonce->user_id,
            'image' => [
                'path' => public_path('/uploads/image/' . $annonce->image),
                'url' => asset('/uploads/image/' . $annonce->image),
            ],
        ];
    });

    return response()->json([
        'status' => 200,
        'annonces' => $formattedAnnonces->toArray(),
    ]);
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'prix' => 'required',
            'user_id' => 'required',
            'location' => 'required',
            'livraison' => 'required',
            'cat_id' => 'required',
            'user_id' => 'required'
        ]);
    
        $annonce = new Annonce();
        $annonce->titre = $request->input('titre');
        $annonce->description = $request->input('description');
        $annonce->prix = $request->input('prix');
        $annonce->location = $request->input('location');
        $annonce->livraison = $request->input('livraison');
        $annonce->cat_id = $request->input('cat_id');
        $annonce->user_id = $request->input('user_id');
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
    
            // Save the file to the storage disk
            \Image::make($image)->resize(300, 300)->save(public_path('/uploads/image/' . $filename));
    
            // Update the user's avatar in the database
            $annonce->image = $filename;
        }
    
        $annonce->save();
    
        return response()->json([
            'success' => 'Annonce ajoutée avec succès',
            'status' => 200,
        ]);
    }
    

    public function show(Annonce $annonce)
    {
        if (!$annonce) {
            return response()->json(['error' => 'Annonce not found'], 404);
        }
    
        // Add details to the response
        $responseData = [
            'id' => $annonce->id,
            'titre' => $annonce->titre,
            'description' => $annonce->description,
            'prix' => $annonce->prix,
            'location' => $annonce->location,
            'livraison' => $annonce->livraison,
            'cat_id' => $annonce->cat_id,
            'user_id' => $annonce->user_id,
            'image' => [
                'path' => public_path('/uploads/image/' . $annonce->image),
                'url' => asset('/uploads/image/' . $annonce->image),
            ],
        ];
    
        // Assuming your Annonce model has an 'image' attribute
        
    
        return response()->json($responseData, 200);
     
    }
    


   /**
 * Update the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  \App\Models\Annonce  $annonce
 * @return \Illuminate\Http\Response
 */


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
            'image' => 'image|mimes:jpeg,png,jpg,gif', // Validate image format
            'prix' => 'required',
            'location' => 'required',
            'livraison' => 'required',
            'cat_id' => 'required'
        ]);

        // Update the fields except for 'image'
        $annonce->update($request->except('image'));

        // Handle image update
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();

            \Image::make($image)->resize(300, 300)->save(public_path('/uploads/image/' . $filename));

            // Delete the old image if it exists
            if ($annonce->image) {
                unlink(public_path('/uploads/image/' . $annonce->image));
            }

            // Update the image field in the database
            $annonce->image = $filename;
            $annonce->save();
        }

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
        if (!$annonce) {
            return response()->json(['error' => 'Annonce not found'], 404);
        }

        // Delete the associated image if it exists
        if ($annonce->image) {
            unlink(public_path('/uploads/image/' . $annonce->image));
        }

        $annonce->delete();

        return response()->json(['message' => 'Annonce deleted'], 204);
    }
}
