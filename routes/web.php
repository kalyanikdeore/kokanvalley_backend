<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\WhyChooseController;
use App\Http\Controllers\Api\CoreValueController;
use App\Http\Controllers\Api\VisionMissionController;
use App\Http\Controllers\Api\AboutSectionController;
use App\Http\Controllers\Api\ProductController;
// use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\AboutKonkanController;
use App\Http\Controllers\Api\AboutKokanValleyController;
use App\Http\Controllers\Api\HeroSectionController;
use App\Http\Controllers\Api\ResortController;
use App\Http\Controllers\Api\GuestExperienceController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ContactInformationController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ProjectDetailController;
use App\Http\Controllers\Api\ClientTestimonialController;
use App\Http\Controllers\Api\KonkanGalleryController;
use App\Http\Controllers\Api\AmenityGalleryController;
use App\Http\Controllers\Api\StaticAmenitiesGalleryController;

Route::prefix('/api')->controller(HomeController::class)->group(function () { 
Route::get('/why-choose', [WhyChooseController::class, 'index']);
Route::get('core-values', [CoreValueController::class, 'index']);
Route::get('vision-mission', [VisionMissionController::class, 'index']);
Route::get('/about-section', [AboutSectionController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
// Route::get('/testimonials', [TestimonialController::class, 'index']);
Route::get('/about-konkan', [AboutKonkanController::class, 'index']);
Route::get('/about-kokan-valley', [AboutKokanValleyController::class, 'index']);
Route::get('/hero-sections', [HeroSectionController::class, 'index']);
Route::get('/resorts', [ResortController::class, 'index']); 
Route::get('/guest-experiences', [GuestExperienceController ::class, 'index']);
Route::get('/gallery', [GalleryController::class, 'index']);
Route::post('/contact', [ContactController::class, 'store'])->withoutMiddleware(['web']);
Route::get('/contact-information', [ContactInformationController::class, 'index']);
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{slug}', [ProjectDetailController::class, 'show']);
Route::get('/client-testimonials', [ClientTestimonialController::class, 'index']);
Route::get('/konkan-gallery', [KonkanGalleryController::class, 'index']);
Route::get('/amenities-gallery', [AmenityGalleryController::class, 'index']);
Route::get('/static-amenities-gallery', [StaticAmenitiesGalleryController::class, 'index']);
});
