<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/auth', [\App\Http\Controllers\Api\AuthController::class, 'auth']);
Route::get('/validate-otp/{email}/{otp}', [\App\Http\Controllers\Api\AuthController::class, 'validateOtp']);
Route::get('/remaining-token/{email}', [\App\Http\Controllers\Api\AuthController::class, 'getCurrentRemainingToken']);
// Route::post('/test-encrypt', [\App\Http\Controllers\Api\AuthController::class, 'testEncrypt']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/interview-result', [\App\Http\Controllers\Api\InterviewController::class, 'saveInterviewResult'])->middleware('auth:sanctum');
Route::get('/interview-results/{email}', [\App\Http\Controllers\Api\InterviewController::class, 'getInterviewResults'])->middleware('auth:sanctum');
Route::get('/interview-results-all/{email}/{order}', [\App\Http\Controllers\Api\InterviewController::class, 'getInterviewResultsAll'])->middleware('auth:sanctum');
Route::get('/interview-result/{email}/{interviewId}', [\App\Http\Controllers\Api\InterviewController::class, 'getInterviewResult'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
});


Route::get('test-email', [\App\Http\Controllers\Api\AuthController::class, 'testEmail']);


