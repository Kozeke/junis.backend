<?php

use App\Http\Controllers\Api\PublicationController;
use App\Http\Controllers\FrontendController;
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
Route::get('/findPublication', ['App\Http\Controllers\Api\PublicationController', 'search']);
Route::get('/findPublicationByTime', ['App\Http\Controllers\Api\PublicationController', 'searchByTime']);
Route::get('/findStories', ['App\Http\Controllers\Api\StoryController', 'search']);
Route::get('/findStoriesByTime', ['App\Http\Controllers\Api\StoryController', 'searchByTime']);
Route::get("/frontend-gallery",[FrontendController::class,"gallery"]);
Route::get("/frontend-story",[FrontendController::class,"stories"]);
//All Story
Route::get("/frontend-gallery",[FrontendController::class,"gallery"]);
Route::get("/frontend-story",[FrontendController::class,"stories"]);
Route::get("/frontend-publications",[FrontendController::class,"allPublications"]);
Route::get("/show-publication/{id}",[FrontendController::class,"showPublication"]);
Route::get("/download-publication/{id}",[FrontendController::class,"downloadPublication"]);
