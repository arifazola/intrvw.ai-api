<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InterviewResults;
use Illuminate\Http\Request;
use Libraries\Encryptor;

class InterviewController extends Controller
{
    //
    public function saveInterviewResult(Request $request){

        if($request->email != $request->user()->currentAccessToken()->tokenable->email){
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        $encryptedText = $request->text;
        // $encryptor = new Encryptor();
        $decryptedText = InterviewController::decrypt($encryptedText, "8Q5cRCqsJ22r8Iw7pgZ2hlzpv2UaStW1");

        $interviewResultObj = json_decode($decryptedText); 

        $interviewResultModel = new InterviewResults;

        $interviewResultModel->user_id = 12;
        $interviewResultModel->score = 30;
        $interviewResultModel->feedback = $decryptedText;
        $interviewResultModel->summary = "Keep it up";

        $save = $interviewResultModel->save();

        
        return response()->json([
            "status" => $save
        ]);
    }

    function decrypt($string, $key) {
        $cipher = "AES-256-CBC";

        // Decode the Base64 encoded string
        $c = base64_decode($string);

        // Get the IV length for the cipher
        $ivlen = openssl_cipher_iv_length($cipher);
        
        // Extract the IV (first $ivlen bytes)
        $iv = substr($c, 0, $ivlen);

        // Extract the ciphertext (remaining bytes)
        $ciphertext = substr($c, $ivlen);

        // Debug: Output IV and ciphertext in hex format to check if they are properly extracted
        echo "IV (Hex): " . bin2hex($iv) . "\n";
        echo "Ciphertext (Hex): " . bin2hex($ciphertext) . "\n";

        // Perform the decryption
        $original_plaintext = openssl_decrypt($ciphertext, $cipher, $key, OPENSSL_RAW_DATA, $iv);

        if ($original_plaintext === false) {
            echo "Decryption errorrr: " . openssl_error_string() . "\n";
        }

        return $original_plaintext;
    }
}
