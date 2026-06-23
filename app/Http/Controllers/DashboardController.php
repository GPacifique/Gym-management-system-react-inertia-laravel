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
    

    /*
    |--------------------------------------------------------------------------
    | MEMBER
    |--------------------------------------------------------------------------
    */
    public function member()
    {
        return Inertia::render('Dashboard/Member');
    }
    /*
|--------------------------------------------------------------------------
| TRAINER
|--------------------------------------------------------------------------
*/
public function trainer()
{
    $trainer = auth()->user()->trainer;

    if (!$trainer) {
        return Inertia::render('Dashboard/Trainer', [
            'trainer' => [
                'name' => auth()->user()->name,
            ],

            'stats' => [
                'total_members' => 0,
                'active_members' => 0,
                'monthly_earnings' => 0,
                'today_sessions' => 0,
            ],

            'recentClients' => [],
            'upcomingSessions' => [],
        ]);
    }

    return Inertia::render('Dashboard/Trainer', [
        'trainer' => $trainer,

        'stats' => [
            'total_members' => $trainer->members()->count(),
            'active_members' => $trainer->members()->where('status', 'active')->count(),
            'monthly_earnings' => 0,
            'today_sessions' => 0,
        ],

        'recentClients' => [],
        'upcomingSessions' => [],
    ]);
}
    public function receptionDashboard()
{
    $newMembers = Member::whereDate('created_at', today())->count();
$total_members=Member::whereDate('created_at', today())->count();
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
public function redirect()
{
    $user = auth()->user();

    return match ($user->role) {

        'super_admin' => redirect()->route('superadmin.dashboard'),

        'business_owner' => redirect()->route('owner.dashboard'),

        'manager' => redirect()->route('manager.dashboard'),

        'receptionist' => redirect()->route('reception.dashboard'),

        'trainer' => redirect()->route('trainer.dashboard'),

        'member' => redirect()->route('member.dashboard'),

        default => abort(403),
    };
}
}