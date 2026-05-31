<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TrainerController extends Controller
{
    /**
     * Display all trainers for current gym
     */
    public function index()
    {
        $gymId = Auth::user()->gym_id;

        $trainers = Trainer::withCount('members')
            ->where('gym_id', $gymId)
            ->latest()
            ->paginate(10);

        return Inertia::render('Trainers/Index', [
            'trainers' => $trainers,
        ]);
    }

    /**
     * Show create trainer form
     */
    public function create()
    {
        return Inertia::render('Trainers/Create');
    }

    /**
     * Store trainer
     */
    public function store(Request $request)
    {
        $gymId = Auth::user()->gym_id;

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'nullable|email|unique:trainers,email',
            'phone' => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'hire_date' => 'nullable|date',
        ]);

        Trainer::create([
            ...$validated,
            'gym_id' => $gymId,
        ]);

        return redirect()
            ->route('trainers.index')
            ->with('success', 'Trainer created successfully.');
    }

    /**
     * Show trainer details with assigned members
     */
    public function show($id)
    {
        $gymId = Auth::user()->gym_id;

        $trainer = Trainer::with('members')
            ->where('gym_id', $gymId)
            ->findOrFail($id);

        return Inertia::render('Trainers/Show', [
            'trainer' => $trainer,
        ]);
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $gymId = Auth::user()->gym_id;

        $trainer = Trainer::where('gym_id', $gymId)
            ->findOrFail($id);

        return Inertia::render('Trainers/Edit', [
            'trainer' => $trainer,
        ]);
    }

    /**
     * Update trainer
     */
    public function update(Request $request, $id)
    {
        $gymId = Auth::user()->gym_id;

        $trainer = Trainer::where('gym_id', $gymId)
            ->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'nullable|email|unique:trainers,email,' . $trainer->id,
            'phone' => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'hire_date' => 'nullable|date',
        ]);

        $trainer->update($validated);

        return redirect()
            ->route('trainers.index')
            ->with('success', 'Trainer updated successfully.');
    }

    /**
     * Delete trainer
     */
    public function destroy($id)
    {
        $gymId = Auth::user()->gym_id;

        $trainer = Trainer::where('gym_id', $gymId)
            ->findOrFail($id);

        $trainer->delete();

        return redirect()
            ->route('trainers.index')
            ->with('success', 'Trainer deleted successfully.');
    }
}