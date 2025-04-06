<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\EbookCheckout;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Str;
use Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function orderlist()
    {
        $order = EbookCheckout::all();
        return Inertia::render('Book/OrderList',[
            'order'  => $order,
        ]);
    }

    public function index()
    {
        $book = Book::all();
        return Inertia::render('Book/BookList',[
            'book'  => $book,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Book/BookForm');
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
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bookthum' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ebookpdf' => 'nullable|mimes:pdf',
            'video' => 'nullable|string|url',
        ]);

        // Handle file upload if provided
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail')->store('thumbnails', 'public');
        }else{
            $thumbnail = null;
        }

        if ($request->hasFile('bookthum')) {
            $bookthum = $request->file('bookthum')->store('bookthum', 'public');
        }else{
            $bookthum = null;
        }

        if ($request->hasFile('ebookpdf')) {
            $ebookpdf = $request->file('ebookpdf')->store('ebookpdf', 'public');
        }else{
            $ebookpdf = null;
        }

        Book::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'discount' => $request->discount,
            'thumbnail' => $thumbnail,
            'bookthum' => $bookthum,
            'ebookpdf' => $ebookpdf,
            'videos' => $request->video,
            'slug' => Str::slug($request-> title), 
        ]);

        return redirect()->route('books.index')->with('success', 'Book added successfully.');

        
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
        $book = Book::findOrFail($id);
        return Inertia::render('Book/EditForm',[
            'book'  => $book
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the book
        $book = Book::findOrFail($id);

        // Validate the request
        $validator = $request -> validate( [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
            'bookthum' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
            'ebookpdf' => 'nullable|mimes:pdf|max:10240', // 10MB max
            'videos' => 'nullable|url',
        ]);

        // Handle file uploads
        if ($request->hasFile('thumbnail')) {
            // Delete the old thumbnail if it exists
            if ($book->thumbnail && Storage::disk('public')->exists($book->thumbnail)) {
                Storage::disk('public')->delete($book->thumbnail);
            }
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $book->thumbnail = $thumbnailPath;
        }

        if ($request->hasFile('bookthum')) {
            // Delete the old bookthum if it exists
            if ($book->bookthum && Storage::disk('public')->exists($book->bookthum)) {
                Storage::disk('public')->delete($book->bookthum);
            }
            $bookthumPath = $request->file('bookthum')->store('bookthums', 'public');
            $book->bookthum = $bookthumPath;
        }

        if ($request->hasFile('ebookpdf')) {
            // Delete the old ebookpdf if it exists
            if ($book->ebookpdf && Storage::disk('public')->exists($book->ebookpdf)) {
                Storage::disk('public')->delete($book->ebookpdf);
            }
            $ebookpdfPath = $request->file('ebookpdf')->store('ebooks', 'public');
            $book->ebookpdf = $ebookpdfPath;
        }

        // Update the book
        $book->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'discount' => $request->discount,
            'videos' => $request->videos,
        ]);

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the book
        $book = Book::findOrFail($id);

        // Delete associated files from storage
        if ($book->thumbnail && Storage::disk('public')->exists($book->thumbnail)) {
            Storage::disk('public')->delete($book->thumbnail);
        }

        if ($book->bookthum && Storage::disk('public')->exists($book->bookthum)) {
            Storage::disk('public')->delete($book->bookthum);
        }

        if ($book->ebookpdf && Storage::disk('public')->exists($book->ebookpdf)) {
            Storage::disk('public')->delete($book->ebookpdf);
        }

        // Delete the book from the database
        $book->delete();

        return redirect()->back()->with('warning',$book.'Deleted Succefull');
    }
}
