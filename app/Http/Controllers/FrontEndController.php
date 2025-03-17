<?php

namespace App\Http\Controllers;
use App\Models\Course;
use Inertia\Inertia;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{

    public function test(){
        return Inertia::render('Test');
    }
   public function course($slug)
   {
       $courses = Course::with('curriculums')->where('slug', $slug)->firstOrFail();
   
       // Ensure the thumbnail contains the full image URL
       if ($courses->thumbnail) {
           $courses->thumbnail = asset('storage/' . $courses->thumbnail);
       }
   
       return Inertia::render('Course', [
           'courses' => $courses // Use singular 'course' instead of 'courses'
       ]);
   }
   
   public function checkout($slug)
   {
       $course = Course::with('curriculums')->where('slug', $slug)->firstOrFail();
   
       // Ensure the thumbnail contains the full image URL
       if ($course->thumbnail) {
           $course->thumbnail = asset('storage/' . $course->thumbnail);
       }
   
       return Inertia::render('Checkout', [
           'courses' => $course // Use singular 'course' instead of 'courses'
       ]);
   }

   public function privacy(){
    return Inertia::render('Privacy');
   }

   public function terms(){
    return Inertia::render('Terms');
   }

   public function userdashboard(){
    return Inertia::render('User/Dashboard');
   }
   
}
