<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::orderBy('last_name')->paginate(20);
        return view('staff.index', compact('staff'));
    }

    public function create()
    {
        $roles = \Spatie\Permission\Models\Role::orderBy('name')->get(['id','name']);
        $userEmails = \App\Models\User::whereNotNull('email')->orderBy('email')->pluck('email');
        return view('staff.create', compact('roles','userEmails'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'branch' => 'nullable|in:RWANDA,TANZANIA',
            'discipline' => 'nullable|in:Football,Basketball',
            'gender' => 'nullable|in:Male,Female',
            'dob' => 'nullable|date',
            'role_function' => 'nullable|string|max:255',
            'date_entry' => 'nullable|date',
            'date_exit' => 'nullable|date',
            'other_organizations' => 'nullable|string',
            'academic_qualification' => 'nullable|string',
            'major' => 'nullable|string|max:255',
            'professional_certificates' => 'nullable|string',
            'tshirt_size' => 'nullable|string|max:50',
            'short_size' => 'nullable|string|max:50',
            'top_tracksuit_size' => 'nullable|string|max:50',
            'pant_tracksuit_size' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255|unique:staff,email|exists:users,email',
            'role_name' => 'nullable|exists:roles,name',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('photos/staff', 'public');
        }

        $roleName = $data['role_name'] ?? null;
        unset($data['role_name']);
        $staff = Staff::create($data);
        if ($roleName) {
            // If Staff also has a related User account later, you may link role there.
            // For now we store chosen role as role_function if role_function empty
            if (empty($staff->role_function)) {
                $staff->role_function = $roleName;
                $staff->save();
            }
        }

        return redirect()->route('staff.index')->with('status', 'Staff profile created');
    }

    public function show(Staff $staff)
    {
        return view('staff.show', compact('staff'));
    }

    public function edit(Staff $staff)
    {
        $roles = \Spatie\Permission\Models\Role::orderBy('name')->get(['id','name']);
        $userEmails = \App\Models\User::whereNotNull('email')->orderBy('email')->pluck('email');
        return view('staff.edit', compact('staff','roles','userEmails'));
    }

    public function update(Request $request, Staff $staff)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'branch' => 'nullable|in:RWANDA,TANZANIA',
            'discipline' => 'nullable|in:Football,Basketball',
            'gender' => 'nullable|in:Male,Female',
            'dob' => 'nullable|date',
            'role_function' => 'nullable|string|max:255',
            'date_entry' => 'nullable|date',
            'date_exit' => 'nullable|date',
            'other_organizations' => 'nullable|string',
            'academic_qualification' => 'nullable|string',
            'major' => 'nullable|string|max:255',
            'professional_certificates' => 'nullable|string',
            'tshirt_size' => 'nullable|string|max:50',
            'short_size' => 'nullable|string|max:50',
            'top_tracksuit_size' => 'nullable|string|max:50',
            'pant_tracksuit_size' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255|unique:staff,email,' . $staff->id . '|exists:users,email',
            'role_name' => 'nullable|exists:roles,name',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($staff->photo_path) {
                Storage::disk('public')->delete($staff->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('photos/staff', 'public');
        }

        $roleName = $data['role_name'] ?? null;
        unset($data['role_name']);
        $staff->update($data);
        if ($roleName && empty($staff->role_function)) {
            $staff->role_function = $roleName;
            $staff->save();
        }

        return redirect()->route('staff.index')->with('status', 'Staff profile updated');
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->route('staff.index')->with('status', 'Staff deleted');
    }
}
