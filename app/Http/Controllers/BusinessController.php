<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BusinessController extends Controller
{
    /**
     * DISPLAY ALL
     */
    public function index()
    {
        $businesses = Business::latest()->paginate(10);

        return Inertia::render('Businesses/Index', [
            'businesses' => $businesses
        ]);
    }

    /**
     * CREATE FORM
     */
    public function create()
    {
        return Inertia::render('Businesses/Create');
    }

    /**
     * STORE
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'logo' => 'nullable|image|max:2048',
            'cover_image' => 'nullable|image|max:4096',
            'email' => 'nullable|email',
            'phone' => 'nullable|max:50',
            'website' => 'nullable|max:255',
            'country' => 'nullable|max:255',
            'city' => 'nullable|max:255',
            'address' => 'nullable|max:255',
            'description' => 'nullable',
            'type' => 'nullable|max:255',
            'is_active' => 'boolean',
        ]);

        // Upload logo
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')
                ->store('businesses/logos', 'public');
        }

        // Upload cover image
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')
                ->store('businesses/covers', 'public');
        }

        $validated['slug'] = Str::slug($validated['name']);

        Business::create($validated);

        return redirect()
            ->route('businesses.index')
            ->with('success', 'Business created successfully.');
    }

    /**
     * SHOW SINGLE
     */
    public function show(Business $business)
    {
        return Inertia::render('Businesses/Show', [
            'business' => $business
        ]);
    }

    /**
     * EDIT FORM
     */
    public function edit(Business $business)
    {
        return Inertia::render('Businesses/Edit', [
            'business' => $business
        ]);
    }

    /**
     * UPDATE
     */
    public function update(Request $request, Business $business)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'logo' => 'nullable|image|max:2048',
            'cover_image' => 'nullable|image|max:4096',
            'email' => 'nullable|email',
            'phone' => 'nullable|max:50',
            'website' => 'nullable|max:255',
            'country' => 'nullable|max:255',
            'city' => 'nullable|max:255',
            'address' => 'nullable|max:255',
            'description' => 'nullable',
            'type' => 'nullable|max:255',
            'is_active' => 'boolean',
        ]);

        // Replace logo
        if ($request->hasFile('logo')) {

            if ($business->logo) {
                Storage::disk('public')->delete($business->logo);
            }

            $validated['logo'] = $request->file('logo')
                ->store('businesses/logos', 'public');
        }

        // Replace cover image
        if ($request->hasFile('cover_image')) {

            if ($business->cover_image) {
                Storage::disk('public')->delete($business->cover_image);
            }

            $validated['cover_image'] = $request->file('cover_image')
                ->store('businesses/covers', 'public');
        }

        $validated['slug'] = Str::slug($validated['name']);

        $business->update($validated);

        return redirect()
            ->route('businesses.index')
            ->with('success', 'Business updated successfully.');
    }

    /**
     * DELETE
     */
    public function destroy(Business $business)
    {
        // Delete files
        if ($business->logo) {
            Storage::disk('public')->delete($business->logo);
        }

        if ($business->cover_image) {
            Storage::disk('public')->delete($business->cover_image);
        }

        $business->delete();

        return redirect()
            ->route('businesses.index')
            ->with('success', 'Business deleted successfully.');
    }
}