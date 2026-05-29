<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Attendance;
Use Illuminate\Support\Facades\App;
Use App\Models\Booking;
Use App\Models\Member;
Use APP\Models\Payment;
Use App\Models\Activity;
class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SUPER ADMIN
    |--------------------------------------------------------------------------
    */
    public function superAdmin()
    {
        return Inertia::render('Dashboard/SuperAdmin');
    }

    /*
    |--------------------------------------------------------------------------
    | BUSINESS OWNER
    |--------------------------------------------------------------------------
    */
    public function owner()
    {
        return Inertia::render('Dashboard/Owner');
    }

    /*
    |--------------------------------------------------------------------------
    | MANAGER
    |--------------------------------------------------------------------------
    */
    public function manager()
    {
        return Inertia::render('Dashboard/Manager');
    }

    /*
    |--------------------------------------------------------------------------
    | RECEPTIONIST
    |--------------------------------------------------------------------------
    */
    public function reception()
    {
        return Inertia::render('Dashboard/Reception');
    }

    /*
    |--------------------------------------------------------------------------
    | TRAINER
    |--------------------------------------------------------------------------
    */
    public function trainer()
    {
        return Inertia::render('Dashboard/Trainer');
    }

    /*
    |--------------------------------------------------------------------------
    | MEMBER
    |--------------------------------------------------------------------------
    */
    public function member()
    {
        return Inertia::render('Dashboard/Member');
    }
    public function receptionDashboard()
{
    $newMembers = Member::whereDate('created_at', today())->count();

    $todayCheckins = Attendance::whereDate('created_at', today())->count();

    $pendingPayments = Payment::where('status', 'pending')->count();

    $recentActivities = Activity::latest()
        ->take(10)
        ->get()
        ->map(function ($activity) {
            return [
                'id' => $activity->id,
                'member_name' => $activity->member?->name ?? 'N/A',
                'action' => $activity->action,
                'time' => $activity->created_at->format('h:i A'),
                'status' => ucfirst($activity->status),
            ];
        });

    return Inertia::render('Reception/Dashboard', [
        'stats' => [
            'new_members' => $newMembers,
            'today_checkins' => $todayCheckins,
            'pending_payments' => $pendingPayments,
        ],

        'recentActivities' => $recentActivities,
    ]);
}
}