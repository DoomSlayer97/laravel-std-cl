<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/auth", [ UserController::class, "auth" ]);

Route::group(["middleware" => ["jwt.verify"]], function() {
    
    /* User Routes */
    Route::post("/users", [ UserController::class, "create" ]);
    Route::get("/users", [ UserController::class, "findAll" ]);
    Route::get("/users/{id}", [ UserController::class, "findOne" ]);
    Route::put("/users/{id}", [ UserController::class, "update" ]);
    
    /* Project Routes */
    Route::post("/projects", [ ProjectController::class, "create" ]);
    Route::get("/projects", [ ProjectController::class, "findAll" ]);
    Route::get("/projects/{id}", [ ProjectController::class, "findOne" ]);

});     


