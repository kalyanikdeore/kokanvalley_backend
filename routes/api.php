<?php

//use App\Http\Controllers\API\ContactController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// routes/api.php
use App\Http\Controllers\ContactController;

Route::post('/contact', [ContactController::class, 'store']);

//Route::post('/contact', [ContactController::class, 'store']);
Route::get('/contact', [ContactController::class, 'index'])->middleware('auth:sanctum');