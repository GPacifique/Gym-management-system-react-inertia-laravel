<?php

namespace App\Http\Controllers;

use App\Models\MembershipPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MembershipPlanController extends Controller
{
    /**
     * Display a listing of membership plans.
     */
    public function index()
    {
        $plans = MembershipPlan::where('gym_id', Auth::user()->gym_id)
            ->latest()
            ->paginate(10);

        return Inertia::render('MembershipPlans/Index', [
            'plans' => $plans,
        ]);
    }

    /**
     * Show the form for creating a new membership plan.
     */
    public function create()
    {
        return Inertia::render('MembershipPlans/Create');
    }

    /**
     * Store a newly created membership plan.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        MembershipPlan::create([
            'gym_id' => Auth::user()->gym_id,
            'name' => $validated['name'],
            'duration_days' => $validated['duration_days'],
            'price' => $validated['price'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('membership-plans.index')
            ->with('success', 'Membership plan created successfully.');
    }

    /**
     * Display the specified membership plan.
     */
    public function show(MembershipPlan $membershipPlan)
    {
        $this->authorizePlan($membershipPlan);

        return Inertia::render('MembershipPlans/Show', [
            'plan' => $membershipPlan,
        ]);
    }

    /**
     * Show the form for editing the specified membership plan.
     */
    public function edit(MembershipPlan $membershipPlan)
    {
        $this->authorizePlan($membershipPlan);

        return Inertia::render('MembershipPlans/Edit', [
            'plan' => $membershipPlan,
        ]);
    }

    /**
     * Update the specified membership plan.
     */
    public function update(Request $request, MembershipPlan $membershipPlan)
    {
        $this->authorizePlan($membershipPlan);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $membershipPlan->update($validated);

        return redirect()
            ->route('membership-plans.index')
            ->with('success', 'Membership plan updated successfully.');
    }

    /**
     * Remove the specified membership plan.
     */
    public function destroy(MembershipPlan $membershipPlan)
    {
        $this->authorizePlan($membershipPlan);

        $membershipPlan->delete();

        return redirect()
            ->route('membership-plans.index')
            ->with('success', 'Membership plan deleted successfully.');
    }

    /**
     * Ensure the plan belongs to the authenticated user's gym.
     */
    private function authorizePlan(MembershipPlan $membershipPlan)
    {
        abort_if(
            $membershipPlan->gym_id !== Auth::user()->gym_id,
            403,
            'Unauthorized action.'
        );
    }
}
