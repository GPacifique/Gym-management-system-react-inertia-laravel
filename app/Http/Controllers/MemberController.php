<?php

namespace App\Http\Controllers;
use App\Models\Membership;
use App\Models\MembershipPlan;
use Carbon\Carbon;
use App\Models\Member;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Services\TwilioService;
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
    $gymId = auth()->user()->gym_id;

    return Inertia::render('Members/Create', [
        'plans' => MembershipPlan::where('gym_id', $gymId)
            ->where('is_active', true)
            ->get(),
    ]);
}

   
       public function store(Request $request, TwilioService $twilio = null)
{
    $user = auth()->user();

    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'nullable|email',
        'phone' => 'nullable|string',
        'status' => 'required',
        'membership_plan_id' => 'required|exists:membership_plans,id',
        'branch_id' => 'nullable|exists:branches,id',
    ]);

    $plan = MembershipPlan::findOrFail($validated['membership_plan_id']);

    $member = Member::create([
        'gym_id' => $user->gym_id,
        'member_number' => $this->generateMemberNumber($user->gym_id),
        'scan_code' => (string) \Str::uuid(),

        'first_name' => $validated['first_name'],
        'last_name' => $validated['last_name'],
        'email' => $validated['email'] ?? null,
        'phone' => $validated['phone'] ?? null,
        'status' => $validated['status'],
        'branch_id' => $validated['branch_id'] ?? $user->branch_id,
    ]);

    /**
     * 🧠 AUTO CREATE MEMBERSHIP
     */
    $startDate = Carbon::now();

    $endDate = match ($plan->duration_type) {
        'days' => $startDate->copy()->addDays($plan->duration),
        'weeks' => $startDate->copy()->addWeeks($plan->duration),
        'months' => $startDate->copy()->addMonths($plan->duration),
        'years' => $startDate->copy()->addYears($plan->duration),
        default => $startDate->copy()->addMonths(1),
    };

    $membership = Membership::create([
        'gym_id' => $user->gym_id,
        'member_id' => $member->id,
        'membership_plan_id' => $plan->id,
        'start_date' => $startDate,
        'end_date' => $endDate,
        'amount' => $plan->price,
        'status' => 'active',
        'created_by' => $user->id,
    ]);

    /**
     * Notification (optional)
     */
    $message = "Welcome {$member->first_name}, you're now on {$plan->name} plan.";

    if ($twilio && $member->phone) {
        $twilio->sendSms($member->phone, $message);
    }

    return redirect()->route('members.index')
        ->with('success', 'Member created with membership successfully');
}
   
public function show(Member $member)
{
    $gymId = auth()->user()->gym_id;

    abort_if($member->gym_id !== $gymId, 403);

    return Inertia::render('Members/Show', [
        'member' => $member,
        'membership' => $member->activeMembership()->with('membershipPlan')->first(),
        'payments' => $member->payments ?? [],
        'attendance' => $member->attendance ?? [],
    ]);
}
public function edit(Member $member)
{
    $user = auth()->user();

    // 🔒 SaaS security: ensure tenant isolation
    abort_if($member->gym_id !== $user->gym_id, 403);

    // Get active plans for this gym
    $plans = MembershipPlan::where('gym_id', $user->gym_id)
        ->where('is_active', true)
        ->get();

    // Load current membership (if exists)
    $membership = $member->memberships()
        ->latest()
        ->first();

    return Inertia::render('Members/Edit', [
        'member' => $member,
        'plans' => $plans,
        'membership' => $membership,
    ]);
}

    public function update(Request $request, Member $member)
    {
        abort_if($member->gym_id !== auth()->user()->gym_id, 403);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive,suspended,expired',
            'branch_id' => 'nullable|exists:branches,id',
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

    /**
     * Generate unique member number per gym
     */
    private function generateMemberNumber($gymId)
    {
        $count = Member::where('gym_id', $gymId)->count() + 1;

        return 'M' . str_pad($gymId, 3, '0', STR_PAD_LEFT)
             . str_pad($count, 5, '0', STR_PAD_LEFT);
    }
}