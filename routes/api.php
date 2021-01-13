<?php

use App\Http\Controllers\Api\PublicationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::post('/login', ['App\Http\Controllers\Api\Auth\LoginController', 'login']);
Route::get('/user', ['App\Http\Controllers\Api\Auth\LoginController', 'user']);
Route::post('/logout', ['App\Http\Controllers\Api\Auth\LoginController', 'logout']);
Route::group(["middleware"=>"auth"],function (){
    Route::resources([
        'publications' => PublicationController::class
    ]);
});
