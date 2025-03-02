<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCurriculum;
use Illuminate\Http\Request;
use Inertia\Inertia;
use DB;
class CourseCurriculumController extends Controller
{

    public function curriculumlist(){
        $course = Course::with('curriculums')->get();
        return Inertia::render('Courses/Curriculum/CurriculumList',[
            'course'    => $course
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();
        return Inertia::render('Courses/Curriculum/CurriculumForm',[
            'courses'    => $courses
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
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'curriculums' => 'required|array',
            'curriculums.*.week' => 'required|string',
            'curriculums.*.carriculum' => 'required|string',
            'curriculums.*.details' => 'nullable|string',
        ]);

        foreach ($request->curriculums as $curriculumData) {
           CourseCurriculum::create([
                'course_id' => $request->course_id,
                'week' => $curriculumData['week'],
                'topic' => $curriculumData['carriculum'],
                'details' => $curriculumData['details'] ?? null,
            ]);
        }

        return redirect()->route('curriculum.index')->with('success', 'Course created successfully.');
    
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
        // Fetch the course and its associated curriculums
    $course = Course::with('curriculums')->findOrFail($id);

    // Return the data to the Vue component
    return Inertia::render('Courses/Curriculum/CurriculumEdit', [
        'course' => $course,
        'curriculums' => $course->curriculums,
    ]);                              
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $courseId)
{
    $request->validate([
        'curriculums' => 'required|array',
        'curriculums.*.week' => 'required|string',
        'curriculums.*.topic' => 'required|string',
        'curriculums.*.details' => 'nullable|string',
    ]);

    $course = Course::find($courseId);
    
    DB::transaction(function () use ($request, $course) {
        // Ensure course exists
        if (!$course) {
            abort(404, 'Course not found');
        }
    
        // Delete existing curriculums
        $course->curriculums()->delete();
    
        // Insert new curriculums
        foreach ($request->curriculums as $curriculumData) {
            CourseCurriculum::create([
                'course_id' => $course->id, // Ensure course_id is correctly assigned
                'week' => $curriculumData['week'],
                'topic' => $curriculumData['topic'],
                'details' => $curriculumData['details'] ?? null,
            ]);
        }
    });
    

    return redirect()->route('curriculum.list')->with('success', 'Curriculum updated successfully!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
