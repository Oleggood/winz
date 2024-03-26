<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Back;
use App\Http\Controllers\Front;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RoleAdminMiddleware;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Pluralizer;
use Inertia\Inertia;
use Illuminate\Foundation\Application;


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


Route::group(['prefix' => 'ru'], function () {


    Route::get('/', [Front\PageController::class, 'home'])->name('home'); //главная - без авторизации
    Route::get('/info/{url}', [Front\PageController::class, 'page']); //без авторизации (о проекте)


    //были после развертывания пустого проекта - стоковые laravel:
//    Route::get('/', function () {
//        return Inertia::render('Welcome', [
//            'canLogin' => Route::has('login'),
//            'canRegister' => Route::has('register'),
//            'laravelVersion' => Application::VERSION,
//            'phpVersion' => PHP_VERSION,
//        ]); // сток
//    });


    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware([
        'auth',
//        'verified'
    ])->name('dashboard'); // сток


    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); // сток
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); // сток
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // сток

        //Back:
        //Admin:
        Route::middleware([RoleAdminMiddleware::class])->prefix('win-admin')->group(function () {
            Route::get('/users', function () {
                return 'юзерс - CRUD для админа, модернизировать и использовать имеющиеся? + добавить index, show';
            });
            Route::get('/travels', function () {
                return Inertia::render('Back/Admin/Travels/List');
            });
        });
        //Admin/
        //Back/


        //Front

        //Front/

    });


//конец стоковых laravel


});
require __DIR__ . '/auth.php';















