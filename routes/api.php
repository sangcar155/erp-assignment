<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\SalesOrderApiController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/login', function (Request $request) {
    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    return response()->json([
        'token' => $user->createToken('api-token')->plainTextToken
    ]);
});


// Admin only
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::apiResource('products', ProductApiController::class);
});

// Admin + Salesperson
Route::middleware(['auth:sanctum', 'role:admin,sales'])->group(function () {
    Route::post('/sales-orders', [SalesOrderApiController::class, 'store']);
    Route::get('/sales-orders/{id}', [SalesOrderApiController::class, 'show']);
});



