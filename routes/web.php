<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Back;
use App\Http\Controllers\Front;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Pluralizer;

Route::get('/{locale}', function (string $locale) {
    if (! in_array($locale, ['en', 'ru',])) {
        abort(400);
    }

    $xxx = App::setLocale($locale);
    dd($xxx);
    //так установить префикс!
});




//были после развертывания пустого проекта laravel:

//use App\Http\Controllers\ProfileController;
//use Illuminate\Foundation\Application;
//use Illuminate\Support\Facades\Route;
//use Inertia\Inertia;

//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});
//
//
//Route::get('/dashboard', function () {
//    return Inertia::render('Dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');
//
//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

require __DIR__ . '/auth.php';
