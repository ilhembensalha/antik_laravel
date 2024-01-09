<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function addToFavorites(Request $request)
    {
        $userId = $request->input('user_id');
        $annonceId = $request->input('annonce_id');

        $favorite = Favorite::firstOrCreate([
            'user_id' => $user->id,
            'annonce_id' => $annonceId,
        ]);

        return response()->json(['message' => 'Ajouté aux favoris']);
    }

    public function removeFromFavorites(Request $request)
    {
      
        $userId = $request->input('user_id');
        $annonceId = $request->input('annonce_id');

        $favorite = Favorite::where('user_id', $userId)
            ->where('annonce_id', $annonceId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['message' => 'Retiré des favoris']);
        }

        return response()->json(['message' => 'Non trouvé dans les favoris'], 404);
    }

    public function getFavorites(Request $request)
    {
        // Récupérer l'ID de l'utilisateur depuis la demande
        $userId = $request->input('user_id');
    
        // Récupérer les favoris de l'utilisateur avec les annonces associées
        $favorites = Favorite::where('user_id', $userId)
            ->with('annonce')
            ->get();
    
        return response()->json(['favorites' => $favorites]);
    }
}
