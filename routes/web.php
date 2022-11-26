<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/", function () {
    return redirect()->route("list");
});

Route::prefix('users')->group(function (){
    Route::get("/add", [UserController::class, "add"])->name("user_add");
    Route::get("/{page_number?}", [UserController::class, "users"])->name("list");
    
    Route::get("/edit/{id}", [UserController::class, "edit"])->name("user_edit");
    Route::get("/show/{id}", [UserController::class, "user"])->name("user_detail");
    Route::get("/delete/{id}", [UserController::class, "delete"])->name("user_delete");
    
    Route::post("/create", [UserController::class, "create"])->name("user_create");
    Route::post("/update/{id}", [UserController::class, "update"])->name("user_update");
});
