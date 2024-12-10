<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    public function renewUserInterviewToken(Request $request){
        try{
            if($request->email != $request->user()->currentAccessToken()->tokenable->email){
                return response()->json([
                    'message' => 'Unauthenticated'
                ], 401);
            }
    
            $user = User::where('email', $request->email)->firstOrFail();
            $user->remaining_token = 3;
    
            $user->save();
    
            return response()->json([
                "message" => "Interview token updated",
                "remaining_token" => 3
            ]);
        }catch(Exception $e){
            return response()->json([
                "message" => "An unknown error has occured. Please try again"
            ], 500);
        }
    }
}
