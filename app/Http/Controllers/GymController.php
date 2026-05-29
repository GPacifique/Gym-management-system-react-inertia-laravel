<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreGymRequest;
use App\Notifications\GymCreatedNotification;
use Inertia\Inertia;

class GymController extends Controller
{
    public function index()
    {
        return Inertia::render('Gyms/Index', [
            'gyms' => Gym::with('owner')->latest()->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('Gyms/Create', [
            'users' => User::whereNull('gym_id')->get()
        ]);
    }

    public function store(StoreGymRequest $request)
    {
        $gym = Gym::create($request->validated());

        if ($request->owner_id) {
            $owner = User::findOrFail($request->owner_id);

            $owner->gym_id = $gym->id;

            // Spatie role system (correct way)
            $owner->syncRoles(['gym_owner']);

            $owner->save();

            // Notify owner
            $owner->notify(new GymCreatedNotification($gym));

            $gym->update([
                'owner_id' => $owner->id
            ]);
        }

        return redirect()->route('gyms.index')
            ->with('success', 'Gym created successfully');
    }

    public function edit(Gym $gym)
    {
        return Inertia::render('Gyms/Edit', [
            'gym' => $gym->load('owner'),
            'users' => User::all()
        ]);
    }

    public function update(StoreGymRequest $request, Gym $gym)
    {
        $gym->update($request->validated());

        return redirect()->route('gyms.index')
            ->with('success', 'Gym updated successfully');
    }

    public function destroy(Gym $gym)
    {
        // optional safety cleanup
        if ($gym->owner_id) {
            $owner = User::find($gym->owner_id);
            if ($owner) {
                $owner->gym_id = null;
                $owner->removeRole('gym_owner');
                $owner->save();
            }
        }

        $gym->delete();

        return back()->with('success', 'Gym deleted');
    }
}