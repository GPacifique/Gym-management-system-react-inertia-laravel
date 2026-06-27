<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGymRequest;
use App\Http\Requests\UpdateGymRequest;
use App\Models\Gym;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class GymController extends Controller
{
    /**
     * Display gyms.
     */
    public function index()
    {
        return Inertia::render('Gyms/Index', [
            'gyms' => Gym::with(['owner', 'subscriptionPlan'])
                ->latest()
                ->get(),
        ]);
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return Inertia::render('Gyms/Create', [
            'users' => User::all(),
        ]);
    }

    /**
     * Store gym.
     */
    public function store(StoreGymRequest $request)
    {
        $data = $request->validated();

        // Generate slug automatically
        $data['slug'] = Str::slug($data['name']);

        // Upload logo
        if ($request->hasFile('logo')) {
            $data['logo'] = $request
                ->file('logo')
                ->store('gyms', 'public');
        }

        $gym = Gym::create($data);

        // Assign owner if selected
        if (!empty($data['owner_id'])) {
            $owner = User::find($data['owner_id']);

            if ($owner) {
                $owner->gym_id = $gym->id;

                if (method_exists($owner, 'syncRoles')) {
                    $owner->syncRoles(['gym_owner']);
                }

                $owner->save();
            }
        }

        return redirect()
            ->route('superadmin.gyms.index')
            ->with('success', 'Gym created successfully.');
    }

    /**
     * Show gym.
     */
    public function show(Gym $gym)
    {
        return Inertia::render('Gyms/Show', [
            'gym' => $gym->load(['owner', 'subscriptionPlan']),
        ]);
    }

    /**
     * Edit gym.
     */
    public function edit(Gym $gym)
    {
        return Inertia::render('Gyms/Edit', [
            'gym' => $gym,
            'users' => User::all(),
        ]);
    }

    /**
     * Update gym.
     */
    public function update(UpdateGymRequest $request, Gym $gym)
    {
        $data = $request->validated();

        // Regenerate slug if name changes
        $data['slug'] = Str::slug($data['name']);

        if ($request->hasFile('logo')) {

            if ($gym->logo) {
                Storage::disk('public')->delete($gym->logo);
            }

            $data['logo'] = $request
                ->file('logo')
                ->store('gyms', 'public');
        }

        $gym->update($data);

        return redirect()
            ->route('superadmin.gyms.index')
            ->with('success', 'Gym updated successfully.');
    }

    /**
     * Delete gym.
     */
    public function destroy(Gym $gym)
    {
        if ($gym->logo) {
            Storage::disk('public')->delete($gym->logo);
        }

        $gym->delete();

        return redirect()
            ->route('superadmin.gyms.index')
            ->with('success', 'Gym deleted successfully.');
    }
}