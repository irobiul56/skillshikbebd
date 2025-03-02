<?php

namespace App\Http\Controllers;
use App\Models\Course;
use Inertia\Inertia;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function course($slug){
        $courses = Course::with('curriculums')-> where('slug', $slug)->firstOrFail();
        return Inertia::render('Course',[
            'courses'    => $courses
        ]);
    }
    public function checkout($slug){
        $courses = Course::with('curriculums')-> where('slug', $slug)->firstOrFail();
        return Inertia::render('Checkout',[
            'courses'    => $courses
        ]);
    }
}
