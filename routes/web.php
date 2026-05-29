<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    HomeController,
    DashboardController,
    ProfileController,
    SecurityController,
    AnalyticsController,
    MemberController,
    StaffController,
    TrainerController,
    BranchController,
    AttendanceController,
    BookingController,
    PaymentController,
    SubscriptionController,
    WorkoutProgramController,
    NutritionPlanController,
    PosController
};
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\GymController;

Route::middleware(['auth', 'role:super_admin'])->group(function () {

    Route::get('/gyms', [GymController::class, 'index'])->name('gyms.index');

    Route::get('/gyms/create', [GymController::class, 'create'])->name('gyms.create');

    Route::post('/gyms', [GymController::class, 'store'])->name('gyms.store');

    Route::get('/gyms/{gym}/edit', [GymController::class, 'edit'])->name('gyms.edit');

    Route::put('/gyms/{gym}', [GymController::class, 'update'])->name('gyms.update');

    Route::delete('/gyms/{gym}', [GymController::class, 'destroy'])->name('gyms.destroy');

});

Route::get('/activities', [ActivityController::class, 'index'])
    ->name('activities.index');

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| AUTHENTICATED
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD REDIRECT
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        return match (auth()->user()->role) {
            'super_admin'     => redirect()->route('superadmin.dashboard'),
            'business_owner'  => redirect()->route('owner.dashboard'),
            'manager'         => redirect()->route('manager.dashboard'),
            'receptionist'    => redirect()->route('reception.dashboard'),
            'trainer'         => redirect()->route('trainer.dashboard'),
            default           => redirect()->route('member.dashboard'),
        };
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | PROFILE (ALL USERS)
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    /*
    |--------------------------------------------------------------------------
    | SUPER ADMIN (FULL ACCESS)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['checkrole:super_admin'])->group(function () {

        Route::get('/superadmin/dashboard', [DashboardController::class, 'superAdmin'])
            ->name('superadmin.dashboard');

        Route::resource('branches', BranchController::class);
        Route::resource('members', MemberController::class);
        Route::get('/security', [SecurityController::class, 'index'])->name('security.index');
        Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
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
        Route::resource('subscriptions', SubscriptionController::class);
        Route::resource('payments', PaymentController::class);
        Route::resource('workout-programs', WorkoutProgramController::class);
        Route::resource('nutrition-plans', NutritionPlanController::class);
        Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    });

    /*
    |--------------------------------------------------------------------------
    | MANAGER (FULL OPERATION CONTROL)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['checkrole:manager,super_admin'])->group(function () {

        Route::get('/manager/dashboard', [DashboardController::class, 'manager'])
            ->name('manager.dashboard');

        Route::resource('members', MemberController::class);
        Route::resource('attendance', AttendanceController::class);
        Route::resource('bookings', BookingController::class);
        Route::resource('payments', PaymentController::class);
        Route::resource('subscriptions', SubscriptionController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | RECEPTIONIST
    |--------------------------------------------------------------------------
    */
    Route::middleware(['checkrole:receptionist,manager,super_admin'])->group(function () {

        Route::get('/reception/dashboard', [DashboardController::class, 'reception'])
            ->name('reception.dashboard');

        Route::resource('members', MemberController::class);
        Route::resource('attendance', AttendanceController::class);
        Route::resource('bookings', BookingController::class);
        Route::resource('payments', PaymentController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | TRAINER
    |--------------------------------------------------------------------------
    */
    Route::middleware(['checkrole:trainer,super_admin'])->group(function () {

        Route::get('/trainer/dashboard', [DashboardController::class, 'trainer'])
            ->name('trainer.dashboard');

        Route::resource('members', MemberController::class);
        Route::resource('workout-programs', WorkoutProgramController::class);
        Route::resource('nutrition-plans', NutritionPlanController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | MEMBER
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'checkrole:super_admin,manager,receptionist'])->group(function () {
    Route::resource('members', MemberController::class);
});
    Route::middleware(['checkrole:member'])->group(function () {

        Route::get('/member/dashboard', [DashboardController::class, 'member'])
            ->name('member.dashboard');

        Route::get('/my-bookings', [BookingController::class, 'myBookings'])
            ->name('bookings.mine');

        Route::get('/my-subscriptions', [SubscriptionController::class, 'mySubscriptions'])
            ->name('subscriptions.mine');
    });
});