<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberNotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MemberPaymentController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\TrainerPaymentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\TrainerMemberController;
use App\Http\Controllers\MembershipPlanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnalyticsController;
use APP\Http\Controllers\GymController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\MemberReceiptController;
use App\Http\Controllers\MemberSubscriptionController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\WorkoutProgramController;
use App\Http\Controllers\NutritionPlanController;
use App\Http\Controllers\TrainerSessionController;
// public
Route::get('/', [HomeController::class, 'index'])
    ->name('home');
    //Authenticated
    Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'redirect'])
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

});
//Admin
Route::middleware(['auth', 'checkrole:manager'])
    ->prefix('manager')
    ->name('manager.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'manager'])
            ->name('dashboard');

        // other manager routes...
    });
//Receptionist
Route::middleware(['auth', 'checkrole:receptionist'])
    ->prefix('reception')
    ->name('reception.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'receptionDashboard'])
            ->name('dashboard');
    });

//Super Admin
Route::middleware(['auth', 'checkrole:super_admin'])
    ->prefix('super-admin')
    ->name('superadmin.')
    ->group(function () {

        Route::get('/dashboard',
            [DashboardController::class, 'superAdmin'])
            ->name('dashboard');

        Route::resource('gyms', GymController::class);

        Route::resource('branches', BranchController::class);

        Route::resource('staff', StaffController::class);

        Route::resource('trainers', TrainerController::class);

        Route::get('/analytics',
            [AnalyticsController::class, 'index'])
            ->name('analytics');

        Route::get('/security',
            [SecurityController::class, 'index'])
            ->name('security');
    });
    //Gym Management Routes
    Route::middleware([
    'auth',
    'checkrole:business_owner,manager,receptionist'
])->group(function () {

    Route::resource('members', MemberController::class);

    Route::resource(
        'membership-plans',
        MembershipPlanController::class
    );

    Route::resource(
        'memberships',
        MembershipController::class
    );
Route::resource('member-subscriptions', MemberSubscriptionController::class);
    Route::resource(
        'membership-payments',
        MemberPaymentController::class
    );
    Route::resource('member-payments', MemberPaymentController::class);
    Route::resource('member-receipts', MemberReceiptController::class);

    Route::resource(
        'member-notifications',
        MemberNotificationController::class
    );

    Route::resource(
        'attendance',
        AttendanceController::class
    );

    Route::resource(
        'bookings',
        BookingController::class
    );
});
//Membership Actions
Route::middleware(['auth'])
    ->prefix('memberships')
    ->name('memberships.')
    ->group(function () {

        Route::post('{membership}/renew', [
            MembershipController::class,
            'renew'
        ])->name('renew');

        Route::post('{membership}/freeze', [
            MembershipController::class,
            'freeze'
        ])->name('freeze');

        Route::post('{membership}/cancel', [
            MembershipController::class,
            'cancel'
        ])->name('cancel');

        Route::post('{membership}/upgrade', [
            MembershipController::class,
            'upgrade'
        ])->name('upgrade');
    });
    //Trainer
    Route::middleware([
    'auth',
    'checkrole:trainer'
])
->prefix('trainer')
->name('trainer.')
->group(function () {

    Route::get('/dashboard',
        [DashboardController::class, 'trainer'])
        ->name('dashboard');

    Route::resource(
        'members',
        TrainerMemberController::class
    );

    Route::resource(
        'sessions',
        TrainerSessionController::class
    );

    Route::resource(
        'payments',
        TrainerPaymentController::class
    );

    Route::get('/profile',
        [ProfileController::class, 'trainer'])
        ->name('profile');
});
//Programs
Route::middleware([
    'auth',
    'checkrole:business_owner,manager,trainer'
])->group(function () {

    Route::resource(
        'workout-programs',
        WorkoutProgramController::class
    );

    Route::resource(
        'nutrition-plans',
        NutritionPlanController::class
    );
});
//Member Portal
Route::middleware([
    'auth',
    'checkrole:member'
])
->prefix('member')
->name('member.')
->group(function () {

    Route::get('/dashboard',
        [DashboardController::class, 'member'])
        ->name('dashboard');

    Route::get('/memberships',
        [MembershipController::class, 'myMemberships'])
        ->name('memberships');

    Route::get('/payments',
        [MemberPaymentController::class, 'myPayments'])
        ->name('payments');

    Route::get('/attendance',
        [AttendanceController::class, 'myAttendance'])
        ->name('attendance');

    Route::get('/notifications',
        [MemberNotificationController::class, 'myNotifications'])
        ->name('notifications');

    Route::get('/bookings',
        [BookingController::class, 'myBookings'])
        ->name('bookings');
});
//Reports
Route::middleware([
    'auth',
    'checkrole:business_owner,manager'
])
->prefix('reports')
->name('reports.')
->group(function () {

    Route::get('/members',
        [AnalyticsController::class, 'members'])
        ->name('members');

    Route::get('/memberships',
        [AnalyticsController::class, 'memberships'])
        ->name('memberships');

    Route::get('/payments',
        [AnalyticsController::class, 'payments'])
        ->name('payments');

    Route::get('/attendance',
        [AnalyticsController::class, 'attendance'])
        ->name('attendance');
});
require __DIR__.'/auth.php';
