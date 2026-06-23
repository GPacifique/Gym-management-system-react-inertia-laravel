<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Trainer;
use App\Models\Service;
use App\Models\Attendance;
use App\Models\MemberSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $gym = auth()->user()->gym;

        $stats = [
            'total_members' => Member::where('gym_id', $gym->id)->count(),

            'active_members' => MemberSubscription::where('gym_id', $gym->id)
                ->where('status', 'active')
                ->count(),

            'expired_members' => MemberSubscription::where('gym_id', $gym->id)
                ->where('status', 'expired')
                ->count(),

            'total_trainers' => Trainer::whereHas('gyms', function ($query) use ($gym) {
                $query->where('gym_id', $gym->id);
            })->count(),

            'total_services' => Service::where('gym_id', $gym->id)->count(),

            'today_attendance' => Attendance::where('gym_id', $gym->id)
                ->whereDate('created_at', today())
                ->count(),
        ];

        return Inertia::render('Analytics/Index', [
            'stats' => $stats,
            'memberGrowth' => $this->memberGrowth($gym->id),
            'attendanceTrend' => $this->attendanceTrend($gym->id),
            'serviceUsage' => $this->serviceUsage($gym->id),
            'subscriptionStatus' => $this->subscriptionStatus($gym->id),
            'topTrainers' => $this->topTrainers($gym->id),
        ]);
    }

    private function memberGrowth($gymId)
    {
        return Member::selectRaw("
                MONTH(created_at) as month,
                COUNT(*) as total
            ")
            ->where('gym_id', $gymId)
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    private function attendanceTrend($gymId)
    {
        return Attendance::selectRaw("
                DATE(created_at) as date,
                COUNT(*) as total
            ")
            ->where('gym_id', $gymId)
            ->whereBetween('created_at', [
                now()->subDays(30),
                now()
            ])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function serviceUsage($gymId)
    {
        return DB::table('attendances')
            ->join('services', 'services.id', '=', 'attendances.service_id')
            ->select(
                'services.name',
                DB::raw('COUNT(attendances.id) as total')
            )
            ->where('attendances.gym_id', $gymId)
            ->groupBy('services.name')
            ->orderByDesc('total')
            ->get();
    }

    private function subscriptionStatus($gymId)
    {
        return MemberSubscription::select(
                'status',
                DB::raw('COUNT(*) as total')
            )
            ->where('gym_id', $gymId)
            ->groupBy('status')
            ->get();
    }

    private function topTrainers($gymId)
    {
        return DB::table('trainer_members')
            ->join('trainers', 'trainers.id', '=', 'trainer_members.trainer_id')
            ->select(
                'trainers.id',
                'trainers.name',
                DB::raw('COUNT(trainer_members.id) as members')
            )
            ->groupBy(
                'trainers.id',
                'trainers.name'
            )
            ->orderByDesc('members')
            ->limit(10)
            ->get();
    }
}