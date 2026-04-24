<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

use App\Http\Controllers\AdminController;

Route::middleware('auth')->group(function () {
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'getNotifications'])->name('notifications.get');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/admin/users', [AdminController::class, 'storeUser']);
    Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/admin/students', [AdminController::class, 'students'])->name('admin.students');
    Route::put('/admin/students/{student}', [AdminController::class, 'updateStudent'])->name('admin.students.update');
    Route::get('/admin/payments', [AdminController::class, 'payments'])->name('admin.payments');
    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/admin/settings', [AdminController::class, 'saveSettings']);
    Route::get('/petugas', fn() => redirect()->route('petugas.verification'));
    Route::prefix('petugas')->name('petugas.')->group(function () {
        Route::get('/verification', [\App\Http\Controllers\PetugasController::class, 'verification'])->name('verification');
        Route::post('/approve/{payment}', [\App\Http\Controllers\PetugasController::class, 'approve'])->name('approve');
        Route::post('/reject/{payment}', [\App\Http\Controllers\PetugasController::class, 'reject'])->name('reject');
        Route::get('/direct', [\App\Http\Controllers\PetugasController::class, 'direct'])->name('direct');
        Route::post('/direct', [\App\Http\Controllers\PetugasController::class, 'storeDirect']);
        Route::get('/search-student', [\App\Http\Controllers\PetugasController::class, 'searchStudent'])->name('search-student');
        Route::get('/invoice/{payment}', [\App\Http\Controllers\PetugasController::class, 'invoice'])->name('invoice');
    });
    Route::get('/siswa', [\App\Http\Controllers\SiswaController::class, 'dashboard'])->name('siswa.dashboard');
    Route::get('/siswa/pay', [\App\Http\Controllers\SiswaController::class, 'payForm'])->name('siswa.pay');
    Route::post('/siswa/pay', [\App\Http\Controllers\SiswaController::class, 'submitPayment']);
    Route::get('/siswa/history', [\App\Http\Controllers\SiswaController::class, 'history'])->name('siswa.history');
});
