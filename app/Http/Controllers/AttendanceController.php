<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Member;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $gymId = auth()->user()->default_gym_id;

        if (!$gymId) {
            abort(403, 'No gym assigned to this user.');
        }

        $attendances = Attendance::with('member')
            ->where('gym_id', $gymId)
            ->latest()
            ->paginate(20)
            ->through(function ($attendance) {
                return [
                    'id' => $attendance->id,
                    'member_name' => $attendance->member
                        ? $attendance->member->first_name . ' ' . $attendance->member->last_name
                        : 'Unknown Member',
                    'check_in_time' => $attendance->check_in_time,
                    'status' => $attendance->status,
                ];
            });

        return inertia('Attendance/Index', [
            'attendances' => $attendances,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => ['required', 'exists:members,id'],
        ]);

        $member = Member::findOrFail($request->member_id);

        /*
        |--------------------------------------------------------------------------
        | SAFE GYM RESOLUTION (CRITICAL FIX)
        |--------------------------------------------------------------------------
        */
        $gymId = auth()->user()->default_gym_id ?? $member->gym_id;

        if (!$gymId) {
            return back()->with('error', 'Gym not assigned to user or member.');
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent duplicate check-in today (per gym)
        |--------------------------------------------------------------------------
        */
        $alreadyCheckedIn = Attendance::where('member_id', $member->id)
            ->where('gym_id', $gymId)
            ->whereDate('created_at', today())
            ->exists();

        if ($alreadyCheckedIn) {
            return back()->with(
                'error',
                $member->first_name . ' already checked in today.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE ATTENDANCE (FIXED)
        |--------------------------------------------------------------------------
        */
        Attendance::create([
            'member_id' => $member->id,
            'gym_id' => $gymId, // ✅ FIXED: NEVER NULL
            'check_in_time' => now(),
            'status' => 'present',
        ]);

        /*
        |--------------------------------------------------------------------------
        | LOG ACTIVITY (SAFE)
        |--------------------------------------------------------------------------
        */
        if (function_exists('logActivity')) {
            logActivity(
                action: 'Member Check-in',
                description: $member->first_name . ' checked into the gym',
                module: 'attendance',
                memberId: $member->id
            );
        }

        return back()->with('success', 'Attendance recorded successfully.');
    }
}