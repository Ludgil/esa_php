<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PonyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WeekController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AppointmentController;


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/', [MainController::class, 'index'])->name('main.index');
    Route::resources(['pony' => PonyController::class, 
        'customer' => CustomerController::class,
        'billing' => BillingController::class
        ], ['except' => ['show']]);
    Route::get('customer/{customer}/customer-detail',[CustomerController::class, 'showCustomer'])->name('customer.customer');
    Route::get('billing/{invoice}/invoice-detail',[BillingController::class, 'showInvoice'])->name('billing.invoice');
    Route::get('/billing/{invoice}/download', [BillingController::class, 'download'])->name('billing.download');
});

Route::prefix('gestion-journaliere')->middleware('auth')->group(function () {
    Route::resource('week', WeekController::class)->except(['show']);
    Route::get('weeks/{week}/appointments', [AppointmentController::class, 'index'])->name('appointment.index');
    Route::get('weeks/{week}/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointment.edit');
    Route::put('weeks/{week}/appointments/{appointment}/edit', [AppointmentController::class, 'update'])->name('appointment.update');
    Route::delete('weeks/{week}/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointment.destroy');
    Route::get('weeks/{week}/appointments/create', [AppointmentController::class, 'create'])->name('appointment.create');
    Route::post('weeks/{week}/appointments', [AppointmentController::class, 'store'])->name('appointment.store');
    Route::get('/weeks/{week}/manage-pony', [WeekController::class, 'managePony'])->name('week.managePony');
    Route::post('/weeks/{week}/update-pony', [WeekController::class, 'updatePony'])->name('week.updatePony');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('user.create');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/admin/users/{user}/edit', [UserController::class, 'update'])->name('user.update');
    Route::post('/admin/users', [UserController::class, 'store'])->name('user.store');
});



require __DIR__.'/auth.php';
