<?php

use App\Http\Controllers\Api\PublicationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StoryController;
use App\Http\Controllers\Api\GalleryController;




Route::post('/login', ['App\Http\Controllers\Api\Auth\LoginController', 'login']);
Route::get('/user', ['App\Http\Controllers\Api\Auth\LoginController', 'user']);
Route::post('/logout', ['App\Http\Controllers\Api\Auth\LoginController', 'logout']);
    Route::resources([
        'publications' => PublicationController::class,
        'stories' => StoryController::class,
        'galleries'=>GalleryController::class,
    ]);

