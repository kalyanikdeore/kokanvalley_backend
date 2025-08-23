<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\WhyChooseController;
use App\Http\Controllers\Api\CoreValueController;
use App\Http\Controllers\Api\VisionMissionController;
use App\Http\Controllers\Api\AboutSectionController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\AboutKonkanController;
use App\Http\Controllers\Api\AboutKokanValleyController;
use App\Http\Controllers\Api\HeroSectionController;
use App\Http\Controllers\Api\ResortController;
use App\Http\Controllers\Api\AmenityController;
use App\Http\Controllers\Api\GuestExperienceController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ContactInformationController;

Route::prefix('/api')->controller(HomeController::class)->group(function () { 
Route::get('/why-choose', [WhyChooseController::class, 'index']);
Route::get('core-values', [CoreValueController::class, 'index']);
Route::get('vision-mission', [VisionMissionController::class, 'index']);
Route::get('/about-section', [AboutSectionController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/testimonials', [TestimonialController::class, 'index']);
Route::get('/about-konkan', [AboutKonkanController::class, 'index']);
Route::get('/about-kokan-valley', [AboutKokanValleyController::class, 'index']);
Route::get('/hero-sections', [HeroSectionController::class, 'index']);
Route::get('/resorts', [ResortController::class, 'index']);
Route::get('/amenities', [AmenityController ::class, 'index']);
Route::get('/guest-experiences', [GuestExperienceController ::class, 'index']);
Route::get('/gallery', [GalleryController::class, 'index']);
Route::post('/contact', [ContactController::class, 'store']);
Route::get('/contact-information', [ContactInformationController::class, 'index']);
});
