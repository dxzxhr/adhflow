<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\SiteController;
/*
|--------------------------------------------------------------------------
| Публичная часть
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'));

/*
|--------------------------------------------------------------------------
| Кабинет пользователя (Breeze)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

    Route::prefix('/profile')->name('profile.')->group(function () {
        Route::get('/',    [ProfileController::class, 'edit'   ])->name('edit');
        Route::patch('/',  [ProfileController::class, 'update' ])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Двухфакторная аутентификация (TOTP)
|--------------------------------------------------------------------------
| Эти маршруты доступны всем вошедшим пользователям,
| но защищённые зоны ниже требуют пройденной 2-FA.
*/
Route::middleware('auth')->group(function () {
    Route::get('/2fa',  [TwoFactorController::class, 'show'  ])->name('twofactor.prompt');
    Route::post('/2fa', [TwoFactorController::class, 'enable'])->name('twofactor.enable');
});

/*
|--------------------------------------------------------------------------
| Защищённые зоны (нужны auth + включённая 2-FA)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', '2fa'])->group(function () {

    /* Админ-панель (пример) */
    Route::get('/admin', fn () => 'Admin panel — доступ разрешён');

    /* Вывод средств  (пока заглушка) */
    Route::post('/withdraw', fn () => 'Withdraw endpoint');
});

Route::middleware(['auth', 'role:webmaster'])->group(function () {
    // стандартные REST-пути + два кастомных для модерации
    Route::resource('sites', SiteController::class);

    Route::post('/sites/{site}/approve', [SiteController::class, 'approve'])
         ->name('sites.approve');

    Route::post('/sites/{site}/reject',  [SiteController::class, 'reject'])
         ->name('sites.reject');
});
/*
|--------------------------------------------------------------------------
| Auth-маршруты пакета Breeze (login, register, reset password…)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
