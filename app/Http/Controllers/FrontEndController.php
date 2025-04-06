<?php

namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\Course;
use App\Models\EbookCheckout;
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

    // dd($request -> all());

    $validatedData = $request->validate([
        'ebook_id' => 'required',
        'payment_method' => 'required|string',
        'transaction_id' => 'required|string',
        'name' => 'required|string',
        'email' => 'required|email',
        'phone' => 'required|string',
        'amount' => 'required',
    ]);


    $order = EbookCheckout::create($validatedData);

    return redirect()->route('thank-you')->with('order', $order);
}

public function showthanks(Request $request)
    {
        // Retrieve the order data from the session
        $order = $request->session()->get('order');

        return inertia('ThankYou', [
            'order' => $order,
        ]);
    }
 
}
