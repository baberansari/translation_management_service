<?php

use App\Http\Controllers\TranslationController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

//  This is normal token Generate for testing the api 

Route::get('/get-token', function (Request $request) {
    $user = User::first();
    $token = $user->createToken('auth_token')->plainTextToken;
    return response()->json([
        'status' => true,
        'message' => 'User logged in successfully',
        'token' =>$token
    ], 200);
}); 

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/translations', [TranslationController::class, 'store']);
    Route::put('/translations/{translation}', [TranslationController::class, 'update']);
    Route::get('/translations/{translation}', [TranslationController::class, 'show']);
    Route::get('/translations/search/data', [TranslationController::class, 'search']);
    Route::get('/translations/export/data', [TranslationController::class, 'export']);
});

