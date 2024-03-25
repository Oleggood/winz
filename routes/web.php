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
use Inertia\Inertia;

//todo:
//Route::group(['middleware' => ['auth', 'admin']], function () {
//    Route::get('/clear', function () {
//        Artisan::call('cache:clear');
//        Artisan::call('config:cache');
//        Artisan::call('view:clear');
//        Artisan::call('route:clear');
//        return "Кэш очищен.";
//    });
//});



//todo - локализация - заменить 'prefix' => 'ru'
//Route::get('/{locale}', function (string $locale) {
//    if (! in_array($locale, ['en', 'ru',])) {
//        $locale = 'ru';
//    }
//
//   App::setLocale($locale);
////    код сюда
//});

//todo:
//Auth::routes(['verify' => false]);


//Route::group(['prefix' => 'ru'], function () {
//    Route::get('/', [Front\PageController::class, 'home'])->name('home');
//});



Route::get('ex', [function() {
    return Inertia::render('Ex');
}]);














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
