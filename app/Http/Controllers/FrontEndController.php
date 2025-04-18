<?php

namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\Course;
use App\Models\CourseCheckout;
use App\Models\EbookCheckout;
use App\Models\LiveClass;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Auth;

class FrontEndController extends Controller
{

    public function test(){
        return Inertia::render('Test');
    }
   public function course($slug)
   {
       $courses = Course::with(['curriculums','gets','tools'])->where('slug', $slug)->firstOrFail();
   
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
    $course = CourseCheckout::where('user_id',  Auth::user()->id,) -> with('course')-> get();
    // dd($course);
    return Inertia::render('User/Dashboard',[
        'course' => $course
    ]);
   }

   public function ebooks(){
    $books = Book::all();
     // Ensure the thumbnail contains the full image URL
     
    return Inertia::render('Book/Books',[
        'books' => $books,
    ]);
    
   }
   
public function ebookcheckout($slug)
{
    
    $ebook = Book::where('slug', $slug)->firstOrFail();

    // Ensure the thumbnail contains the full image URL
    if ($ebook->thumbnail) {
        $ebook->thumbnail = asset('storage/' . $ebook->thumbnail);
    }

    return Inertia::render('Book/EbookCheckout', [
        'ebook' => $ebook // Use singular 'course' instead of 'courses'
    ]);
}

public function checkoutebook(Request $request)
{

    // dd($request ->all());

    $validatedData = $request->validate([
        'ebook_id' => 'required',
        'payment_method' => 'required|string',
        'transaction_id' => 'required|string',
        'name' => 'required|string',
        'email' => 'required|email',
        'phone' => 'required|string',
    ]);


    $order = EbookCheckout::create([
        'ebook_id' => $request-> ebook_id,
        'payment_method' => $request-> payment_method,
        'transaction_id' => $request-> transaction_id,
        'name' => $request-> name,
        'email' => $request-> email,
        'phone' => $request-> phone,
        'amount' => $request-> amount,
        
    ]);

    return redirect()->route('thank-you')->with('success', $order);
}


public function checkoutcourse(Request $request)
{

    $validatedData = $request->validate([
        'course_id' => 'required',
        'payment_method' => 'required|string',
        'transaction_id' => 'required|string',
    ]);


    $order = CourseCheckout::create([
        'course_id' => $request-> course_id,
        'payment_method' => $request-> payment_method,
        'transaction_id' => $request-> transaction_id,
        'amount' => $request-> totalPrice,
        'user_id' => Auth::user() -> id,
    ]);

    return redirect()->route('dashboard');
}


public function showthanks(Request $request)
    {
        // Retrieve the order data from the session
        $order = $request->session()->get('order');

        return inertia('ThankYou', [
            'order' => $order,
        ]);
    }
 
    public function mycourse($id)
    {
        // Get the course with its live classes
        $course = Course::with(['liveclass' => function($query) {
            $query->orderBy('start_time', 'asc');
        }])->findOrFail($id);

        // Check if user has an active checkout for this course
        if (!auth()->user()->checkedOutCourses()->where('course_id', $id)->exists()) {
            
            abort(403, 'You must complete checkout to access this course or If you already checkout this course please wait sometime to active this course');
            // return redirect()->back()->with('success','You must complete checkout to access this course or If you already checkout this course please wait sometime to active this course');
        }

        return Inertia::render('Courses/MyCourse', [
            'course' => $course,
        ]);
    }
}

