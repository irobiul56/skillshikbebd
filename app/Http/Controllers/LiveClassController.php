<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\LiveClass;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Carbon;
use Auth;

class LiveClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $liveclass = LiveClass::with('course')->get();
        return Inertia::render('Courses/Classes/LiveClassList',[
            'liveclass'    => $liveclass,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $course = Course::all();
        return Inertia::render('Courses/Classes/LiveClassForm',[
            'course'    => $course,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request -> all());
        $validated = $request->validate([
            'courseId' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'duration' => 'required|integer|min:15|max:240',
            'platform' => 'required|in:zoom,google_meet,custom',
            'meetingLink' => 'required|url',
            'recordSession' => 'required|boolean',
        ]);

        // Combine date and time into a single datetime
        $startTime = Carbon::createFromFormat(
            'Y-m-d H:i', 
            $validated['date'] . ' ' . $validated['time']
        );

        $liveClass = LiveClass::create([
            'course_id' => $validated['courseId'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_time' => $startTime,
            'duration_minutes' => $validated['duration'],
            'platform' => $validated['platform'],
            'meeting_link' => $validated['meetingLink'],
            'will_record' => $validated['recordSession'],
            'created_by' => Auth::user()->id,
        ]);

        return redirect()->back()->with('success', 'Live class created successfully!');
    
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
