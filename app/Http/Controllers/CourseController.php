<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseYouGet;
use App\Models\Get;
use App\Models\ProductCategoryModel;
use App\Models\Tool;
use App\Models\ToolsTechnology;
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
        $category = ProductCategoryModel::all();
        $getdata = Get::all();
        $tools = Tool::all();
        return Inertia::render('Courses/CourseForm',[
                'category'  => $category,
                'getdata'   => $getdata,
                'tools'     => $tools,
            ]);
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
       $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'liveclass' => 'required|integer',
            'project' => 'required|integer',
            'batch' => 'required|integer',
            'category' => 'required',
            'start' => 'required|date',
            'schedule' => 'required|string',
            'totalclass' => 'required|integer',
            'status' => 'required|string|in:Upcoming,Ongoing,Finished',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|string|url',
            'group' => 'nullable|string|url',
            'gets' => 'required|array',
            'gets.*' => 'exists:gets,id', // Ensure all tag IDs exist
            'tools' => 'required|array',
            'tools.*' => 'exists:tools,id',
        ]);

        // Handle file upload if provided
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
        }else{
            $path = null;
        }

       $course = Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'discount' => $request->discount,
            'live_classes' => $request->liveclass,
            'projects' => $request->project,
            'batch_number' => $request->batch,
            'category_id' => $request->category,
            'start_date' => $request->start,
            'class_schedule' => $request->schedule,
            'total_classes' => $request->totalclass,
            'status' => $request->status,
            'thumbnail' => $path,
            'videos' => $request->video,
            'group' => $request->group,
            'slug' => Str::slug($request-> title), 
        ]);

        // Attach gets to the course (this creates records in course_tag table)
        $course->gets()->attach($validated['gets']);
        $course->tools()->attach($validated['tools']);

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
        $course = Course::with(['gets','tools'])->findOrFail($id);

        // Ensure the thumbnail has a full URL
        if ($course->thumbnail) {
            $course->thumbnail = asset('storage/' . $course->thumbnail);
        }
    
        // Get all available categories, gets and tools
        $category = ProductCategoryModel::all();
        $getdata = Get::all();
        $tools = Tool::all();
    
        // Transform the course data to include only IDs for gets and tools
        $courseData = [
            ...$course->toArray(),
            'gets' => $course->gets->pluck('id')->toArray(),
            'tools' => $course->tools->pluck('id')->toArray(),
        ];
    
        return inertia('Courses/CourseEdit', [
            'course' => $courseData,
            'category' => $category,
            'getdata' => $getdata,
            'tools' => $tools,
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
            'category' => 'required',
            'start' => 'required|date',
            'schedule' => 'required|string',
            'totalclass' => 'required|integer',
            'status' => 'required|string|in:Upcoming,Ongoing,Finished,Draft',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|string|url',
            'group' => 'nullable|string|url',
            'gets' => 'nullable|array',
            'gets.*' => 'exists:gets,id', // Validate each tag exists
            'tools' => 'nullable|array',
            'tools.*' => 'exists:tools,id',
        ]);

        $course -> title = $request -> title;
        $course -> description = $request -> description;
        $course -> price = $request -> price;
        $course -> discount = $request -> discount;
        $course -> live_classes = $request -> liveclass;
        $course -> projects = $request -> project;
        $course -> batch_number = $request -> batch;
        $course -> category_id = $request -> category;
        $course -> start_date = $request -> start;
        $course -> class_schedule = $request -> schedule;
        $course -> total_classes = $request -> totalclass;
        $course -> status = $request -> status;
        $course -> videos = $request -> video;
        $course -> group = $request -> group;
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

    if ($request->has('gets')) {
        $course->gets()->sync($request->gets);
        $course->tools()->sync($request->tools);
    } else {
        $course->gets()->detach(); // Remove all gets if none provided
        $course->tools()->detach(); // Remove all gets if none provided
    }

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
