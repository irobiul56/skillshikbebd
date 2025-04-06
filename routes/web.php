<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseCurriculumController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Models\Course;
use Inertia\Inertia;

Route::get('/', function () {
    
    $courses = Course::where('status', 'upcoming')->get()->map(function ($course) {
        if ($course->thumbnail) {
            $course->thumbnail = asset('storage/' . $course->thumbnail);
        }
        return $course;
    });

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'courses'   => $courses,
    ]);
}) -> name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified','admin'])->name('dashboard');

Route::middleware(['auth','admin'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('courses', CourseController::class);
    Route::resource('curriculum', CourseCurriculumController::class);
    Route::resource('category', CategoryController::class);
    
    Route::put('/courses/{course}/curriculum', [CourseCurriculumController::class, 'update'])
    ->name('courses.curriculum.update');
    Route::get('/curriculum-list', [CourseCurriculumController::class, 'curriculumlist'])->name('curriculum.list');
    Route::get('/courses-list', [CourseController::class, 'courselist'])->name('course.list');
    
    //Book Route
    Route::resource('books', BookController::class);
    Route::get('/book-order-list', [BookController::class, 'orderlist'])->name('book.order.list');

});

Route::get('/course/{slug}', [FrontEndController::class, 'course'])->name('course.single');
Route::get('/chekout/{slug}', [FrontEndController::class, 'checkout'])->name('checkout');
Route::get('/ebook-checkout/{slug}', [FrontEndController::class, 'ebookcheckout'])->name('ebookcheckout');
Route::get('/test', [FrontEndController::class, 'test'])->name('test');
Route::get('/privacy-policy', [FrontEndController::class, 'privacy'])->name('privacy');
Route::get('/terms-and-conditions', [FrontEndController::class, 'terms'])->name('terms');
Route::get('/ebooks', [FrontEndController::class, 'ebooks'])->name('ebooks');
Route::post('/checkoutebook', [FrontEndController::class, 'checkoutebook'])->name('checkoutebook');
Route::get('/thank-you', [FrontEndController::class, 'showthanks'])->name('thank-you');

//user dashboard
Route::get('/user/dashboard', [FrontEndController::class, 'userdashboard']) -> middleware(['auth','user']);

// Payment Option

require __DIR__.'/auth.php';
