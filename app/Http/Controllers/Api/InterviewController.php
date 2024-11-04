<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\InterviewResults;
use Illuminate\Http\Request;
use Libraries\Encryptor;
use Illuminate\Support\Facades\DB;

class InterviewController extends Controller
{
    //
    public function saveInterviewResult(Request $request){

        if($request->email != $request->user()->currentAccessToken()->tokenable->email){
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        try{
            DB::beginTransaction();
            $encryptedText = $request->text;
            $encryptedJobDetail = $request->jobDetail;
            // $encryptor = new Encryptor();
            $decryptedText = InterviewController::decrypt($encryptedText, "8Q5cRCqsJ22r8Iw7pgZ2hlzpv2UaStW1");
            $decryptedJobDetail = InterviewController::decrypt($encryptedJobDetail, "8Q5cRCqsJ22r8Iw7pgZ2hlzpv2UaStW1");
    
            $interviewResultObj = json_decode($decryptedText); 
    
            $jobDetailObj = json_decode($decryptedJobDetail);
    
            $interviewResultModel = new InterviewResults;
    
            $interviewResultModel->score = $request->score;
            $interviewResultModel->user_id = $request->user()->id;
            $interviewResultModel->feedback = $decryptedText;
            $interviewResultModel->summary = "Keep it up";
            $interviewResultModel->interview_title = $jobDetailObj->jobTitle;

            $user = User::where('email', $request->email)->firstOrFail();
            $currentRemainingToken = $user->remaining_token;
            $updatedRemaingToken = $currentRemainingToken - 1;
            $user->remaining_token = $updatedRemaingToken;
    
            
            $save = $interviewResultModel->save();
            
            $user->save();
            DB::commit();

            return response()->json([
                "message" => "Interview result is saved",
                "remaining_token" => $updatedRemaingToken
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                "message" => "An unknown error has occured. Please try again"
            ], 500);
        }
        
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

        // Perform the decryption
        $original_plaintext = openssl_decrypt($ciphertext, $cipher, $key, OPENSSL_RAW_DATA, $iv);

        if ($original_plaintext === false) {
            return response()->json([
                "message" => "We are unable to save your interview result. Please try again"
            ], 500);
        }

        return $original_plaintext;
    }

    public function getInterviewResults(Request $request, string $email){
        if($email != $request->user()->currentAccessToken()->tokenable->email){
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        $data = InterviewResults::where('user_id', $request->user()->id)->orderBy("id", "DESC")->take(3)->get();

        $serializedData = json_encode($data);

        $user = User::where('email', $request->email)->firstOrFail();

        return response()->json([
            // 'message' => "Fetched interview results successfully",
            'results' => $data,
            "remaining_token" => (int)$user->remaining_token
        ]);
    }

    public function getInterviewResultsAll(Request $request, string $email, string $order){
        if($email != $request->user()->currentAccessToken()->tokenable->email){
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        $orderMap = array(
            "Recent" => ['id', 'DESC'],
            "Oldest" => ['id', 'ASC'],
            "Highest Score" => ['score', 'DESC']
        );

        $data = InterviewResults::where('user_id', $request->user()->id)->orderBy($orderMap[$order][0], $orderMap[$order][1])->get();

        $serializedData = json_encode($data);

        return response()->json([
            // 'message' => "Fetched interview results successfully",
            'results' => $data
        ]);
    }

    public function getInterviewResult(Request $request, String $email, String $interviewId){
        if($email != $request->user()->currentAccessToken()->tokenable->email){
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        $data = InterviewResults::where('id', $interviewId)->get();

        $serializedData = json_encode($data);

        return response()->json([
            // 'message' => "Fetched interview results successfully",
            'results' => $data
        ]);
    }
}
