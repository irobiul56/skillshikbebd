<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Storage;

class CourseController extends Controller
{

    public function courselist(){
        $courses = Course::all();
        return Inertia::render('Courses/CourseList',[
            'courses'   => $courses
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Courses/CourseForm');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request -> all());
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'liveclass' => 'required|integer',
            'project' => 'required|integer',
            'batch' => 'required|integer',
            'category' => 'required|string',
            'start' => 'required|date',
            'schedule' => 'required|string',
            'totalclass' => 'required|integer',
            'status' => 'required|string|in:Upcoming,Ongoing,Finished',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|string|url',
        ]);

        // Handle file upload if provided
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
        }else{
            $path = null;
        }

        Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'discount' => $request->discount,
            'live_classes' => $request->liveclass,
            'projects' => $request->project,
            'batch_number' => $request->batch,
            'category' => $request->category,
            'start_date' => $request->start,
            'class_schedule' => $request->schedule,
            'total_classes' => $request->totalclass,
            'status' => $request->status,
            'thumbnail' => $path,
            'videos' => $request->video,
            'slug' => Str::slug($request-> title), 
        ]);

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = Course::findOrFail($id);

        // Ensure the thumbnail has a full URL
        if ($course->thumbnail) {
            $course->thumbnail = asset('storage/thumbnails/' . basename($course->thumbnail));
        }

        return inertia('Courses/CourseEdit', [
            'course' => $course
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        // dd($request -> all());

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'liveclass' => 'required|integer',
            'project' => 'required|integer',
            'batch' => 'required|integer',
            'category' => 'required|string',
            'start' => 'required|date',
            'schedule' => 'required|string',
            'totalclass' => 'required|integer',
            'status' => 'required|string|in:Upcoming,Ongoing,Finished',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|string|url',
        ]);

        $course -> title = $request -> title;
        $course -> description = $request -> description;
        $course -> price = $request -> price;
        $course -> discount = $request -> discount;
        $course -> live_classes = $request -> liveclass;
        $course -> projects = $request -> project;
        $course -> batch_number = $request -> batch;
        $course -> category = $request -> category;
        $course -> start_date = $request -> start;
        $course -> class_schedule = $request -> schedule;
        $course -> total_classes = $request -> totalclass;
        $course -> status = $request -> status;
        $course -> videos = $request -> video;
        $course -> slug = Str::slug($request-> title); 

            // Handle image upload if a new one is provided
    if ($request->hasFile('thumbnail')) {
        // Delete the old image if it exists
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        // Store the new image
        $imagePath = $request->file('thumbnail')->store('thumbnails', 'public');
        $course->thumbnail = $imagePath;
    }

    $course->save();

    return redirect()->route('course.list')->with('message', 'Course updated successfully!');
     
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
