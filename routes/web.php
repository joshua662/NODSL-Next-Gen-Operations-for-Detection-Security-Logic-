<?php

use App\Http\Controllers\Admin\ReportsController;
use App\Livewire\Admin\GateLogs;
use App\Livewire\Admin\Notifications as AdminNotifications;
use App\Livewire\Admin\Reports;
use App\Livewire\Admin\ResidentsManagement;
use App\Livewire\Admin\UpdateRequests;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('residents', ResidentsManagement::class)->name('residents');
    Route::get('gate-logs', GateLogs::class)->name('gate-logs');
    Route::get('update-requests', UpdateRequests::class)->name('update-requests');
    Route::get('reports', Reports::class)->name('reports');
    Route::get('reports/export', [ReportsController::class, 'exportCsv'])->name('reports.export');
    Route::get('notifications', AdminNotifications::class)->name('notifications');
});
