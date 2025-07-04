<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Libraries;
use Libraries\Encryptor;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use App\Helpers\OtpGenerator;
Use Exception;

class AuthController extends Controller
{

    // Login using Gmail
    public function auth(Request $request){
        $user = DB::table("users")->where("email", $request->email)->first();

        if($user){
            return AuthController::processLogin($request);
        } else {
            return AuthController::processRegister($request);
        }
    }

    public function processRegister(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email:filter|max:255|unique:users'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>md5("fjndskelrjkfdmn,cm,nekldfkslrwjerwbndfskldjklerwjklebjkfjldfskerwklfbknds,#%$^%&#$%$%^%#$@$%#$$"),
            'email_verified_at' => date("Y-m-d H:i:s"),
            'remaining_token' => 2
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

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $token = $request->user()->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login success',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'fullname' => $request->user()->name
            ]);
        } else {
            return response()->json([
                'message' => 'Email or password is not correct',
                'access_token' => "",
                'token_type' => 'Bearer'
            ], 401);
        }
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email:filter|max:255|unique:users',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Signup failed',
                'access_token' => null,
                'token_type' => 'Bearer',
                'data' => $validator->errors()
            ], 401);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'verified_at' => null,
            'remaining_token' => 2
        ]);

        

        // $token = $user->createToken('auth_token')->plainTextToken;

        // event(new Registered($user));

        $otpGenerator = new OtpGenerator();
        $otp = $otpGenerator->generate();
        $saveOtp = Otp::create([
            'email' => $request->email,
            'otp' => $otp,
            'valid_until' => date("Y-m-d H:i:s"),
            'is_used' => false,
            'otp_for' => 'register'
        ]);

        AuthController::sendOtp($request->email, $otp);

        return response()->json([
            'message' => 'Signup success',
            'access_token' => "",
            'token_type' => 'Bearer'
        ]);
    }

    public function requestOtpForResetPassword(Request $request){
        try{
            $otpGenerator = new OtpGenerator();
            $otp = $otpGenerator->generate();
            $saveOtp = Otp::create([
                'email' => $request->email,
                'otp' => $otp,
                'valid_until' => date("Y-m-d H:i:s"),
                'is_used' => false,
                'otp_for' => 'reset_password'
            ]);
            AuthController::sendOtp($request->email, $otp);

            return response()->json([
                'message' => 'OTP for reset password has been sent to your email',
                'access_token' => "",
                'token_type' => 'Bearer'
            ]);
        }catch(Exception $e){
            // print_r($e->getMessage());
            return response()->json([
                'message' => 'Something went wrong when requesting OTP. Please try again',
                'access_token' => "",
                'token_type' => 'Bearer'
            ], 401);
        }
        
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

    public function validateOtp(Request $request, string $email, string $otp, string $otpFor){
        $otpFromDb = Otp::where('email', $request->email)->where('otp_for', $otpFor)->orderBy('valid_until', 'desc')->firstOrFail();

        if($otp != $otpFromDb->otp){
            return response()->json([
                'message' => 'OTP Invalid',
                'access_token' => "",
                'token_type' => 'Bearer'
            ], 401);
        }

        if($otpFor != $otpFromDb->otp_for){
            return response()->json([
                'message' => 'otp Invalid',
                'access_token' => "",
                'token_type' => 'Bearer'
            ], 401);
        }

        if($otpFor == "register"){
            $updateUser = DB::table('users')->where('email', $email)->update(['email_verified_at' => date("Y-m-d H:i:s")]);

            $user = User::where('email', $email)->firstOrFail();
    
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'OTP validated',
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]);
        } else {
            $token = Hash::make($email . time() . "P@ssw0rd");
            DB::table("password_reset_tokens")->upsert(
                [
                    ['email' => $email, 'token' => $token, 'created_at' => date("Y-m-d H:i:s")]
                ],
                ['email'],
                ['token']
            );
            return response()->json([
                'message' => 'OTP validated',
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]);
        }

        
    }

    public function updatePassword(Request $request){
        try{
            $passwordResetToken = DB::table('password_reset_tokens')->select('token')->where('email', $request->email)->get();
            if($request->token != $passwordResetToken[0]->token){
                return response()->json([
                    'message' => 'Unauthenticated',
                    'access_token' => "",
                    'token_type' => 'Bearer'
                ], 401);
            }
            $updatePassword = DB::table('users')->where('email', $request->email)->update(['password' => Hash::make($request->password)]);

            return response()->json([
                'message' => 'Password has been changed. You can now login with your new password',
                'access_token' => "",
                'token_type' => 'Bearer'
            ]);
        }catch(Exception $e){
            return response()->json([
                'message' => 'Something went wrong when updating your password. Please try again',
                'access_token' => "",
                'token_type' => 'Bearer'
            ], 401);
        }
    }

    public function getCurrentRemainingToken(Request $request, string $email){

        if($email != $request->user()->currentAccessToken()->tokenable->email){
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        try{
            $user = User::where('email', $email)->firstOrFail();

            $remainingToken = $user->remaining_token;
    
            return response()->json([
                'message' => 'Success',
                'remaining_token' => $remainingToken
            ]);
        } catch(Exception $e){
            return response()->json([
                'message' => 'Error getting remaining token'
            ], 401);
        }

        
    }

    public function sendOtp(string $to, int $otp){
        Mail::to($to)->send(new SendEmail($otp));
    }
}
