<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

            return response()->json(['success' => $success], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

  public function profile($user_id)
{
    $user = User::find($user_id);

    if ($user) {
        return response()->json(['user' => $user], 200);
    } else {
        return response()->json(['error' => 'User not found'], 404);
    }
}
}
