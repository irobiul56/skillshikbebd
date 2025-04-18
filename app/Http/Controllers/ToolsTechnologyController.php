<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\ToolsTechnology;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ToolsTechnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Tool::all();
        return Inertia::render('Courses/Tools/List',[
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Courses/Tools/Form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.title' => 'required|string|max:255',
            'items.*.icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        foreach ($request->items as $itemData) {
           
            $iconPath = null;
            
            if (isset($itemData['icon']) && $itemData['icon']->isValid()) {
                try {
                    // Store in public disk (creates symlink accessible from public)
                    $path = $itemData['icon']->store('icons', 'public');
                    $iconPath = $path; // No need to replace 'public/' as it's already correct
                } catch (\Exception $e) {
                    // Log error or handle it appropriately
                    \Log::error('File upload failed: '.$e->getMessage());
                    continue; // Skip this item or handle differently
                }
            }
    
            Tool::create([
                'title' => $itemData['title'],
                'icon' => $iconPath,
            ]);
        }
    
        return redirect()->route('tools-technology.index')->with('success', 'Created successfully.');
    
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
