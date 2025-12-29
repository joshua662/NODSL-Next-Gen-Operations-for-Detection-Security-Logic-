<?php

use App\Http\Controllers\Admin\ReportsController;
use App\Livewire\Admin\GateLogs;
use App\Livewire\Admin\Notifications as AdminNotifications;
use App\Livewire\Admin\Reports;
use App\Livewire\Admin\ResidentsManagement;
use App\Livewire\Admin\UpdateRequests;
use App\Livewire\Admin\GuestAccessRequests;
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

// Resident routes (authenticated residents only)
Route::middleware(['auth', 'verified', 'resident'])->prefix('resident')->name('resident.')->group(function () {
    Route::get('dashboard', function () {
        return view('resident.dashboard');
    })->name('dashboard');
    
    Route::get('profile', function () {
        return view('resident.profile.show');
    })->name('profile.show');
    
    Route::get('profile/edit', function () {
        return view('resident.profile.edit');
    })->name('profile.edit');
    
    Route::put('profile', [\App\Http\Controllers\Resident\ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('guest-access', function () {
        return view('resident.guest-access');
    })->name('guest-access.create');
    
    Route::post('guest-access', [\App\Http\Controllers\Resident\ProfileController::class, 'storeGuestAccess'])->name('guest-access.store');
    
    Route::get('gate-logs', function () {
        return view('resident.gate-logs');
    })->name('gate-logs');
    
    Route::get('notifications', function () {
        return view('resident.notifications');
    })->name('notifications');
    
    Route::post('notifications/{notification}/mark-read', [\App\Http\Controllers\Resident\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('notifications/mark-all-read', [\App\Http\Controllers\Resident\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    
    Route::get('update-requests', function () {
        return view('resident.update-requests');
    })->name('update-requests');
    
    Route::get('help', function () {
        return view('resident.help');
    })->name('help');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('residents', ResidentsManagement::class)->name('residents');
    Route::get('gate-logs', GateLogs::class)->name('gate-logs');
    Route::get('update-requests', UpdateRequests::class)->name('update-requests');
    Route::get('guest-access-requests', GuestAccessRequests::class)->name('guest-access-requests');
    Route::get('reports', Reports::class)->name('reports');
    Route::get('reports/export', [ReportsController::class, 'exportCsv'])->name('reports.export');
    Route::get('notifications', AdminNotifications::class)->name('notifications');
});
