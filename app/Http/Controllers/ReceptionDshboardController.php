<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

use App\Models\Member;
use App\Models\Attendance;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\Activity;

class ReceptionDashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | MEMBERS
        |--------------------------------------------------------------------------
        */

        $newMembersToday = Member::whereDate(
            'created_at',
            today()
        )->count();

        $totalMembers = Member::count();

        /*
        |--------------------------------------------------------------------------
        | ATTENDANCE
        |--------------------------------------------------------------------------
        */

        $todayCheckins = Attendance::whereDate(
            'created_at',
            today()
        )->count();

        /*
        |--------------------------------------------------------------------------
        | PAYMENTS
        |--------------------------------------------------------------------------
        */

        $pendingPayments = Payment::where(
            'status',
            'pending'
        )->count();

        $todayRevenue = Payment::where(
            'status',
            'completed'
        )
        ->whereDate('created_at', today())
        ->sum('amount');

        /*
        |--------------------------------------------------------------------------
        | BOOKINGS
        |--------------------------------------------------------------------------
        */

        $todayBookings = Booking::whereDate(
            'created_at',
            today()
        )->count();

        /*
        |--------------------------------------------------------------------------
        | RECENT ACTIVITIES
        |--------------------------------------------------------------------------
        */

        $recentActivities = Activity::with([
                'member',
                'user',
            ])
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($activity) {

                return [
                    'id' => $activity->id,

                    'member_name' =>
                        $activity->member?->name
                        ?? 'N/A',

                    'staff_name' =>
                        $activity->user?->name
                        ?? 'System',

                    'action' =>
                        $activity->action,

                    'description' =>
                        $activity->description,

                    'module' =>
                        $activity->module,

                    'status' =>
                        ucfirst($activity->status),

                    'time' =>
                        $activity->created_at
                            ->format('h:i A'),

                    'date' =>
                        $activity->created_at
                            ->format('d M Y'),
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | CHART DATA
        |--------------------------------------------------------------------------
        */

        $memberGrowth = [];

        for ($i = 6; $i >= 0; $i--) {

            $date = now()->subDays($i);

            $memberGrowth[] = [
                'day' => $date->format('D'),

                'members' => Member::whereDate(
                    'created_at',
                    $date
                )->count(),
            ];
        }

        $attendanceChart = [];

        for ($i = 6; $i >= 0; $i--) {

            $date = now()->subDays($i);

            $attendanceChart[] = [
                'day' => $date->format('D'),

                'checkins' => Attendance::whereDate(
                    'created_at',
                    $date
                )->count(),
            ];
        }

        $revenueChart = [];

        for ($i = 6; $i >= 0; $i--) {

            $date = now()->subDays($i);

            $revenueChart[] = [
                'day' => $date->format('D'),

                'revenue' => Payment::where(
                        'status',
                        'completed'
                    )
                    ->whereDate(
                        'created_at',
                        $date
                    )
                    ->sum('amount'),
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | UPCOMING BOOKINGS
        |--------------------------------------------------------------------------
        */

        $upcomingBookings = Booking::with('member')
            ->whereDate(
                'booking_date',
                '>=',
                today()
            )
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($booking) {

                return [
                    'id' => $booking->id,

                    'member_name' =>
                        $booking->member?->name,

                    'service' =>
                        $booking->service,

                    'booking_date' =>
                        $booking->booking_date,

                    'status' =>
                        ucfirst($booking->status),
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return Inertia::render(
            'Reception/Dashboard',
            [

                /*
                |--------------------------------------------------------------------------
                | STATS
                |--------------------------------------------------------------------------
                */

                'stats' => [

                    'new_members' =>
                        $newMembersToday,

                    'total_members' =>
                        $totalMembers,

                    'today_checkins' =>
                        $todayCheckins,

                    'pending_payments' =>
                        $pendingPayments,

                    'today_revenue' =>
                        $todayRevenue,

                    'today_bookings' =>
                        $todayBookings,
                ],

                /*
                |--------------------------------------------------------------------------
                | ACTIVITIES
                |--------------------------------------------------------------------------
                */

                'recentActivities' =>
                    $recentActivities,

                /*
                |--------------------------------------------------------------------------
                | CHARTS
                |--------------------------------------------------------------------------
                */

                'charts' => [

                    'member_growth' =>
                        $memberGrowth,

                    'attendance' =>
                        $attendanceChart,

                    'revenue' =>
                        $revenueChart,
                ],

                /*
                |--------------------------------------------------------------------------
                | BOOKINGS
                |--------------------------------------------------------------------------
                */

                'upcomingBookings' =>
                    $upcomingBookings,
            ]
        );
    }
}