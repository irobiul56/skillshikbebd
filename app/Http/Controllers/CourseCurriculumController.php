<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Curriculum;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CourseCurriculumController extends Controller
{

    public function curriculumlist(){
        $curriculum = Curriculum::with('course')->get();
        return Inertia::render('Courses/Curriculum/CurriculumList',[
            'curriculum'    => $curriculum
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
           Curriculum::create([
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
        // Validate the incoming request data
        public function update(Request $request, Course $course)
        {
            $validated = $request->validate([
                'curriculums' => 'required|array|min:1',
                'curriculums.*.id' => 'nullable|exists:curriculums,id',
                'curriculums.*.week' => 'required|string|max:10',
                'curriculums.*.topic' => 'required|string|max:255',
                'curriculums.*.details' => 'nullable|string',
            ]);
        
            // Get all existing curriculum IDs from the database
            $existingCurriculumIds = $course->curriculums()->pluck('id')->toArray();
            $newCurriculumIds = [];
        
            foreach ($validated['curriculums'] as $curriculumData) {
                if (!empty($curriculumData['id'])) {
                    // Update existing curriculum
                    $curriculum = Curriculum::find($curriculumData['id']);
                    if ($curriculum) {
                        $curriculum->update([
                            'week' => $curriculumData['week'],
                            'topic' => $curriculumData['topic'],
                            'details' => $curriculumData['details'],
                        ]);
                        $newCurriculumIds[] = $curriculum->id; // Track updated ones
                    }
                } else {
                    // Create new curriculum
                    $newCurriculum = $course->curriculums()->create($curriculumData);
                    $newCurriculumIds[] = $newCurriculum->id; // Track new ones
                }
            }
        
            // Find and delete removed curriculums
            $toDelete = array_diff($existingCurriculumIds, $newCurriculumIds);
            Curriculum::destroy($toDelete);
        
            return redirect()->route('curriculum.list')
                ->with('success', 'Curriculum updated successfully!');
        
        }
        

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
