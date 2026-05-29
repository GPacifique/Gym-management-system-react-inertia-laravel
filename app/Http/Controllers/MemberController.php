<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MemberController extends Controller
{
    public function index()
    {
        $gymId = auth()->user()->default_gym_id;

        $members = Member::where('gym_id', $gymId)
            ->latest()
            ->paginate(10);

        return Inertia::render('Members/Index', [
            'members' => $members
        ]);
    }

    public function create()
    {
        return Inertia::render('Members/Create');
    }

    public function store(Request $request)
    {
        $gymId = auth()->user()->default_gym_id;

        $validated = $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'join_date' => 'nullable|date',
            'expiry_date' => 'nullable|date',
        ]);

        Member::create([
            ...$validated,
            'gym_id' => $gymId, // 🔥 FIX ADDED
        ]);

        return redirect()->route('members.index')
            ->with('success', 'Member created successfully');
    }

    public function edit(Member $member)
    {
        return Inertia::render('Members/Edit', [
            'member' => $member
        ]);
    }

    public function update(Request $request, Member $member)
    {
        $member->update($request->all());

        return redirect()->route('members.index')
            ->with('success', 'Member updated');
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('members.index')
            ->with('success', 'Member deleted');
    }

    public function show($id)
    {
        $gymId = auth()->user()->default_gym_id;

        $member = Member::where('gym_id', $gymId)
            ->findOrFail($id);

        return inertia('Members/Show', [
            'member' => $member,
        ]);
    }
}