<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Branch;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StaffController extends Controller
{
    /**
     * Display a listing of staff.
     */
    public function index(Request $request)
    {
        $gymId = auth()->user()->gym_id;

        $staff = Staff::query()
            ->where('gym_id', $gymId)
            ->with('branch')
            ->when($request->search, function ($query, $search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('Staff/Index', [
            'staff' => $staff,
            'filters' => $request->only('search'),
        ]);
    }

    /**
     * Show create form.
     */
    public function create()
    {
        $gymId = auth()->user()->gym_id;

        return Inertia::render('Staff/Create', [
            'branches' => Branch::where('gym_id', $gymId)->get(),
        ]);
    }

    /**
     * Store new staff.
     */
    public function store(Request $request)
    {
        $gymId = auth()->user()->gym_id;

        $validated = $request->validate([
            'branch_id'      => ['nullable', 'exists:branches,id'],
            'first_name'     => ['required', 'string', 'max:255'],
            'last_name'      => ['required', 'string', 'max:255'],
            'email'          => ['nullable', 'email'],
            'phone'          => ['required'],
            'position'       => ['required'],
            'salary'         => ['nullable', 'numeric'],
            'hire_date'      => ['nullable', 'date'],
            'employment_status' => ['required'],
        ]);

        $validated['gym_id'] = $gymId;

        Staff::create($validated);

        return redirect()
            ->route('staff.index')
            ->with('success', 'Staff member created successfully.');
    }

    /**
     * Show specific staff member.
     */
    public function show(Staff $staff)
    {
        $this->authorizeStaff($staff);

        return Inertia::render('Staff/Show', [
            'staff' => $staff->load('branch'),
        ]);
    }

    /**
     * Edit form.
     */
    public function edit(Staff $staff)
    {
        $this->authorizeStaff($staff);

        $gymId = auth()->user()->gym_id;

        return Inertia::render('Staff/Edit', [
            'staff' => $staff,
            'branches' => Branch::where('gym_id', $gymId)->get(),
        ]);
    }

    /**
     * Update staff.
     */
    public function update(Request $request, Staff $staff)
    {
        $this->authorizeStaff($staff);

        $validated = $request->validate([
            'branch_id'      => ['nullable', 'exists:branches,id'],
            'first_name'     => ['required'],
            'last_name'      => ['required'],
            'email'          => ['nullable', 'email'],
            'phone'          => ['required'],
            'position'       => ['required'],
            'salary'         => ['nullable', 'numeric'],
            'hire_date'      => ['nullable', 'date'],
            'employment_status' => ['required'],
        ]);

        $staff->update($validated);

        return redirect()
            ->route('staff.index')
            ->with('success', 'Staff updated successfully.');
    }

    /**
     * Delete staff.
     */
    public function destroy(Staff $staff)
    {
        $this->authorizeStaff($staff);

        $staff->delete();

        return redirect()
            ->route('staff.index')
            ->with('success', 'Staff deleted successfully.');
    }

    /**
     * Activate staff.
     */
    public function activate(Staff $staff)
    {
        $this->authorizeStaff($staff);

        $staff->update([
            'employment_status' => 'active'
        ]);

        return back()->with('success', 'Staff activated.');
    }

    /**
     * Suspend staff.
     */
    public function suspend(Staff $staff)
    {
        $this->authorizeStaff($staff);

        $staff->update([
            'employment_status' => 'suspended'
        ]);

        return back()->with('success', 'Staff suspended.');
    }

    /**
     * Ensure staff belongs to current gym.
     */
    private function authorizeStaff(Staff $staff)
    {
        if ($staff->gym_id !== auth()->user()->gym_id) {
            abort(403);
        }
    }
}