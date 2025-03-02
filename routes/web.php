<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseCurriculumController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Models\Course;
use Inertia\Inertia;

Route::get('/', function () {
    $courses = Course::all();
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'courses'   => $courses,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('courses', CourseController::class);
    Route::resource('curriculum', CourseCurriculumController::class);
    Route::get('/curriculum-list', [CourseCurriculumController::class, 'curriculumlist'])->name('curriculum.list');
    Route::get('/courses-list', [CourseController::class, 'courselist'])->name('course.list');
});

Route::get('/course/{slug}', [FrontEndController::class, 'course'])->name('course.single');
Route::get('/chekout/{slug}', action: [FrontEndController::class, 'checkout'])->name('checkout');


require __DIR__.'/auth.php';
