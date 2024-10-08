<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Libraries;
use Libraries\Encryptor;

class AuthController extends Controller
{

    public function auth(Request $request){
        $user = DB::table("users")->where("email", $request->email)->first();

        if($user){
            return AuthController::processLogin($request);
        } else {
            return AuthController::register($request);
        }
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>md5("fjndskelrjkfdmn,cm,nekldfkslrwjerwbndfskldjklerwjklebjkfjldfskerwklfbknds,#%$^%&#$%$%^%#$@$%#$$"),
            'email_verified_at' => date("Y-m-d H:i:s")
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        event(new Registered($user));

        return response()->json([
            'message' => 'Signup success',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function processLogin(Request $request)
    {
        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login success',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function logout(Request $request)
    {
        if($request->email != $request->user()->currentAccessToken()->tokenable->email){
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $user->tokens()->delete();
        return response()->json([
            'message' => 'logout success'
        ]);
    }
}
