<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Member;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubscriptionController extends Controller
{
    /**
     * ALL SUBSCRIPTIONS
     */
    public function index()
    {
        $subscriptions = Subscription::with([
            'business',
            'member'
        ])
        ->latest()
        ->paginate(10);

        return Inertia::render('Subscriptions/Index', [
            'subscriptions' => $subscriptions
        ]);
    }

    /**
     * CREATE PAGE
     */
    public function create()
    {
        return Inertia::render('Subscriptions/Create', [
            'businesses' => Business::all(),
            'members' => Member::all(),
        ]);
    }

    /**
     * STORE
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'business_id' => 'required|exists:businesses,id',
            'member_id' => 'required|exists:members,id',
            'name' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'duration' => 'required|integer',
            'duration_type' => 'required',
            'start_date' => 'required|date',
            'payment_status' => 'required',
            'payment_method' => 'nullable',
            'transaction_id' => 'nullable',
            'is_active' => 'boolean',
        ]);

        /*
        |--------------------------------------------------------------------------
        | CALCULATE END DATE
        |--------------------------------------------------------------------------
        */

        $start = Carbon::parse($validated['start_date']);

        if ($validated['duration_type'] === 'days') {

            $end = $start->copy()
                ->addDays($validated['duration']);

        } elseif ($validated['duration_type'] === 'months') {

            $end = $start->copy()
                ->addMonths($validated['duration']);

        } else {

            $end = $start->copy()
                ->addYears($validated['duration']);
        }

        $validated['end_date'] = $end;

        Subscription::create($validated);

        return redirect()
            ->route('subscriptions.index')
            ->with('success', 'Subscription created successfully.');
    }

    /**
     * SHOW
     */
    public function show(Subscription $subscription)
    {
        $subscription->load([
            'business',
            'member'
        ]);

        return Inertia::render('Subscriptions/Show', [
            'subscription' => $subscription
        ]);
    }

    /**
     * EDIT
     */
    public function edit(Subscription $subscription)
    {
        return Inertia::render('Subscriptions/Edit', [
            'subscription' => $subscription,
            'businesses' => Business::all(),
            'members' => Member::all(),
        ]);
    }

    /**
     * UPDATE
     */
    public function update(Request $request, Subscription $subscription)
    {
        $validated = $request->validate([
            'business_id' => 'required|exists:businesses,id',
            'member_id' => 'required|exists:members,id',
            'name' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'duration' => 'required|integer',
            'duration_type' => 'required',
            'start_date' => 'required|date',
            'payment_status' => 'required',
            'payment_method' => 'nullable',
            'transaction_id' => 'nullable',
            'is_active' => 'boolean',
        ]);

        $start = Carbon::parse($validated['start_date']);

        if ($validated['duration_type'] === 'days') {

            $end = $start->copy()
                ->addDays($validated['duration']);

        } elseif ($validated['duration_type'] === 'months') {

            $end = $start->copy()
                ->addMonths($validated['duration']);

        } else {

            $end = $start->copy()
                ->addYears($validated['duration']);
        }

        $validated['end_date'] = $end;

        $subscription->update($validated);

        return redirect()
            ->route('subscriptions.index')
            ->with('success', 'Subscription updated successfully.');
    }

    /**
     * DELETE
     */
    public function destroy(Subscription $subscription)
    {
        $subscription->delete();

        return redirect()
            ->route('subscriptions.index')
            ->with('success', 'Subscription deleted successfully.');
    }
}