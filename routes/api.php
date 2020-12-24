<?php

use App\Http\Controllers\Api\PublicationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::post('/login', ['App\Http\Controllers\Api\Auth\LoginController', 'login']);
Route::get('/user', ['App\Http\Controllers\Api\Auth\LoginController', 'user']);
Route::post('/logout', ['App\Http\Controllers\Api\Auth\LoginController', 'logout']);
    Route::resources([
        'publications' => PublicationController::class,
        'stories' => \App\Http\Controllers\Api\StoryController::class
    ]);

