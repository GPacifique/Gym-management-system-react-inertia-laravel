<?php
use App\Models\Gym;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Payment;

class SuperAdminController extends Controller
{
    public function index()
    {
        return Inertia::render('SuperAdmin/Dashboard', [
            'stats' => [
                'totalGyms' => Gym::count(),
                'totalMembers' => User::role('member')->count(),
                'totalTrainers' => User::role('trainer')->count(),
                'activeSubscriptions' => Subscription::where('status', 'active')->count(),
                'pendingPayments' => Payment::where('status', 'pending')->count(),
                'monthlyRevenue' => Payment::where('status', 'paid')
                    ->whereMonth('created_at', now()->month)
                    ->sum('amount'),
            ],

            'recentActivities' => [
                'New gym registered in Kigali',
                'Trainer assigned to gym',
                'New member joined',
                'Payment received',
            ]
        ]);
    }
}