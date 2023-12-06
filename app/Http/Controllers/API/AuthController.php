<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
    
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
    
        // Do not generate a token for registration
        // $success['token'] =  $user->createToken('Bearer')->plainTextToken;
    
        $success['name'] = $user->name;
    
        return response()->json(['success' => $success], 200);
    }
    
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('Bearer')->plainTextToken;
            $success['name'] = $user->name;
            $success['email'] = $user->email;
            $success['id'] = $user->id;
            return response()->json(['success' => $success], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

  public function profile($user_id)
{
    $user = User::find($user_id);

    if ($user) {
        return response()->json( $user, 200);
    } else {
        return response()->json(['error' => 'User not found'], 404);
    }
}


public function getProfile($user_id)
{
    $user = User::find($user_id);

    if ($user) {
        return response()->json(['user' => $user], 200);
    } else {
        return response()->json(['error' => 'User not found'], 404);
    }
}

public function editProfile(Request $request, $user_id)
{
    // Assurez-vous que l'utilisateur actuellement connecté correspond à $user_id
    /*if (Auth::id() != $user_id) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }*/

    // Validez et mettez à jour les champs du profil
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email,'.$user_id,
        'password' => 'nullable|string|min:6',
    ]);

    $user = User::find($user_id);
    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->password != null) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    return response()->json(['success' => 'Profile updated successfully'], 200);
}

public function updateProfileImage(Request $request, $user_id)

{
    $request->validate([
        'avatar' => 'required|image|mimes:jpeg,png,jpg,gif',
    ]);
    if ($request->hasFile('avatar')) {
        $avatar = $request->file('avatar');
        $filename = time() . '.' . $avatar->getClientOriginalExtension();

        // Save the file to the storage disk
        Image::make($avatar)->resize(300, 300)->save(public_path('/uploads/avatar/' . $filename));

        // Update the user's avatar in the database
        $user = User::find($user_id);
        $user->avatar = $filename;
        $user->save();

        return response()->json([
            'success' => 'Profil modifié avec succès',
            'status' => 200,
        ]);
    }

    return response()->json([
        'message' => 'Aucune image n\'a été fournie.',
        'status' => 400,
    ]);
  Log::error('Uploaded file details: ' . json_encode($request->file('avatar')));

}
public function getUserImage($user_id)
{
    $user = User::find($user_id);

    if ($user && $user->avatar) {
        $path = $user->avatar;
        $file = public_path("/uploads/avatar/{$path}");
        if (file_exists($file)) {
            return response()->file($file, ['Content-Type' => 'image/jpeg']);
        } else {
            return response("Image not found", 404);
        }

     
    }

    return response("Image not found", 404);
}
public function uploadimage(Request $request)
{

    $user = $request->user();

    //check file
    if ($request->hasFile('avatar')) {
        $file = $request->file('avatar');
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $file->move('uploads/avatars/', $filename);
        $user->avatar = $filename;
        $user->save();
        $user->update();
        return response()->json(["status" => 200, "message" => "Image ajoutée avec succès"]);
    } else {
        return response()->json(["status" => 200, "message" => "Selectionner une photo"]);
    }
}

}
