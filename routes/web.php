<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\WhyChooseController;
use App\Http\Controllers\Api\CoreValueController;
use App\Http\Controllers\Api\VisionMissionController;
use App\Http\Controllers\Api\AboutSectionController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\HeroController;
use App\Http\Controllers\Api\AboutKonkanController;

Route::prefix('/api')->controller(HomeController::class)->group(function () { 
Route::get('/why-choose', [WhyChooseController::class, 'index']);
Route::get('core-values', [CoreValueController::class, 'index']);
Route::get('vision-mission', [VisionMissionController::class, 'index']);
Route::get('/about-section', [AboutSectionController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/testimonials', [TestimonialController::class, 'index']);
Route::get('/hero-items', [HeroController::class, 'index']);
Route::get('/about-konkan', [AboutKonkanController::class, 'index']);
});
