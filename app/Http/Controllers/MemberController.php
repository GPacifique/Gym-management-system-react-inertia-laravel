<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\TwilioService;
use Illuminate\Support\Facades\Auth;
class MemberController extends Controller
{
    public function index()
    {
        $gymId = auth()->user()->gym_id;

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

    public function store(Request $request, TwilioService $twilio)
    {
        $gymId = auth()->user()->gym_id;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'join_date' => 'nullable|date',
            'expiry_date' => 'nullable|date',
        ]);

        // ✅ SAVE MEMBER
        $member = Member::create([
            ...$validated,
            'gym_id' => $gymId,
        ]);

        // ✅ NOTIFICATION MESSAGE
        $message = "Welcome {$member->name}! Your gym account has been created successfully.";

        // ✅ SEND SMS
        if ($member->phone) {
            $twilio->sendSms($member->phone, $message);

            // ✅ SEND WHATSAPP
            $twilio->sendWhatsApp($member->phone, $message);
        }

        return redirect()
            ->route('members.index')
            ->with('success', 'Member created successfully');
    }

    public function show($id)
    {
        $gymId = auth()->user()->gym_id;

        $member = Member::where('gym_id', $gymId)
            ->findOrFail($id);

        return Inertia::render('Members/Show', [
            'member' => $member,
        ]);
    }

    public function edit(Member $member)
    {
        // 🔐 SECURITY CHECK
        abort_if($member->gym_id !== auth()->user()->gym_id, 403);

        return Inertia::render('Members/Edit', [
            'member' => $member
        ]);
    }

    public function update(Request $request, Member $member)
    {
        abort_if($member->gym_id !== auth()->user()->gym_id, 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'join_date' => 'nullable|date',
            'expiry_date' => 'nullable|date',
        ]);

        $member->update($validated);

        return redirect()
            ->route('members.index')
            ->with('success', 'Member updated successfully');
    }

    public function destroy(Member $member)
    {
        abort_if($member->gym_id !== auth()->user()->gym_id, 403);

        $member->delete();

        return redirect()
            ->route('members.index')
            ->with('success', 'Member deleted successfully');
    }
}