<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    HomeController,
    DashboardController,
    ProfileController,

    GymController,
    MemberController,

    MembershipPlanController,
    MemberSubscriptionController,
    MemberPaymentController,
    MemberReceiptController,
    MemberNotificationController,

    AttendanceController,
    BookingController,

    WorkoutProgramController,
    NutritionPlanController,

    BranchController,
    StaffController,
    TrainerController,

    PosController,
    AnalyticsController,
    SecurityController
};

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| AUTH BASE
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD REDIRECT (RBAC ENTRY)
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        return match (auth()->user()->role) {

            'super_admin'    => redirect()->route('superadmin.dashboard'),
            'business_owner' => redirect()->route('owner.dashboard'),
            'manager'        => redirect()->route('manager.dashboard'),
            'receptionist'   => redirect()->route('reception.dashboard'),
            'trainer'        => redirect()->route('trainer.dashboard'),

            default          => redirect()->route('member.dashboard'),
        };
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    /*
    |--------------------------------------------------------------------------
    | SUPER ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware(['checkrole:super_admin'])->group(function () {

        Route::get('/superadmin/dashboard', [DashboardController::class, 'superAdmin'])
            ->name('superadmin.dashboard');

        Route::resource('gyms', GymController::class);
        Route::resource('branches', BranchController::class);
        Route::resource('members', MemberController::class);

        Route::get('/analytics', [AnalyticsController::class, 'index'])
            ->name('analytics.index');

        Route::get('/security', [SecurityController::class, 'index'])
            ->name('security.index');
    });

    /*
    |--------------------------------------------------------------------------
    | BUSINESS OWNER
    |--------------------------------------------------------------------------
    */
    Route::middleware(['checkrole:business_owner'])->group(function () {

        Route::get('/owner/dashboard', [DashboardController::class, 'owner'])
            ->name('owner.dashboard');

        Route::resource('staff', StaffController::class);
        Route::resource('trainers', TrainerController::class);
        Route::resource('members', MemberController::class);

        /*
        |-------------------------
        | MEMBER SYSTEM (CORE)
        |-------------------------
        */
        Route::resource('membership-plans', MembershipPlanController::class);
        Route::resource('member-subscriptions', MemberSubscriptionController::class);

        Route::resource('member-payments', MemberPaymentController::class);
        Route::resource('member-receipts', MemberReceiptController::class);
        Route::resource('member-notifications', MemberNotificationController::class);

        /*
        |-------------------------
        | PROGRAMS
        |-------------------------
        */
        Route::resource('workout-programs', WorkoutProgramController::class);
        Route::resource('nutrition-plans', NutritionPlanController::class);

        Route::get('/pos', [PosController::class, 'index'])
            ->name('pos.index');
    });

    /*
    |--------------------------------------------------------------------------
    | MANAGER
    |--------------------------------------------------------------------------
    */
    Route::middleware(['checkrole:manager'])->group(function () {

        Route::get('/manager/dashboard', [DashboardController::class, 'manager'])
            ->name('manager.dashboard');

        Route::resource('members', MemberController::class);
        Route::resource('attendance', AttendanceController::class);
        Route::resource('bookings', BookingController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | RECEPTIONIST
    |--------------------------------------------------------------------------
    */
    Route::middleware(['checkrole:receptionist'])->group(function () {

        Route::get('/reception/dashboard', [DashboardController::class, 'reception'])
            ->name('reception.dashboard');

        Route::resource('members', MemberController::class);
        Route::resource('attendance', AttendanceController::class);
        Route::resource('bookings', BookingController::class);

        /*
        | Payments handled ONLY via member-payments
        */
        Route::resource('member-payments', MemberPaymentController::class);
        Route::resource('member-receipts', MemberReceiptController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | TRAINER
    |--------------------------------------------------------------------------
    */
    Route::middleware(['checkrole:trainer'])->group(function () {

        Route::get('/trainer/dashboard', [DashboardController::class, 'trainer'])
            ->name('trainer.dashboard');

        Route::resource('members', MemberController::class);
        Route::resource('workout-programs', WorkoutProgramController::class);
        Route::resource('nutrition-plans', NutritionPlanController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | MEMBER SELF SERVICE
    |--------------------------------------------------------------------------
    */
    Route::middleware(['checkrole:member'])->group(function () {

        Route::get('/member/dashboard', [DashboardController::class, 'member'])
            ->name('member.dashboard');

        Route::get('/my-bookings', [BookingController::class, 'myBookings'])
            ->name('bookings.mine');

        Route::get('/my-subscriptions', [MemberSubscriptionController::class, 'mySubscriptions'])
            ->name('member-subscriptions.mine');

        Route::get('/my-notifications', [MemberNotificationController::class, 'myNotifications'])
            ->name('member-notifications.mine');
    });
});