<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/auth', [\App\Http\Controllers\Api\AuthController::class, 'auth']);
// Route::post('/test-encrypt', [\App\Http\Controllers\Api\AuthController::class, 'testEncrypt']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/interview-result', [\App\Http\Controllers\Api\InterviewController::class, 'saveInterviewResult'])->middleware('auth:sanctum');
Route::get('/interview-results/{email}', [\App\Http\Controllers\Api\InterviewController::class, 'getInterviewResults'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
});


