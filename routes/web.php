<?php

use App\Http\Controllers\Admin\HomePageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::view('/', 'welcome')->name('home');
Route::view('/workforce-passport', 'pages.workforce-passport')->name('passport');
Route::view('/eri', 'pages.eri')->name('eri');
Route::view('/programs', 'pages.programs')->name('programs');
Route::view('/employers', 'pages.employers')->name('employers');
Route::view('/institutions', 'pages.institutions')->name('institutions');
Route::view('/workforce-intelligence', 'pages.workforce-intelligence')->name('intelligence');
Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/create-passport', 'pages.workforce-passport')->name('passport.create');

// Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', 'showLogin')->name('login');
        Route::post('/login', 'login')->name('login.store');
        Route::get('/register', 'showRegister')->name('register');
        Route::post('/register', 'register')->name('register.store');
    });
    Route::post('/logout', 'logout')->name('logout')->middleware('auth');
});

// User Routes
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->controller(UserController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/passport/create', 'createPassport')->name('passport.create');
    Route::post('/passport', 'storePassport')->name('passport.store');
    Route::get('/passports', 'passports')->name('passports');
    Route::get('/opportunities/search', 'searchOpportunities')->name('opportunities.search');
    Route::get('/opportunities/{id}', 'viewOpportunity')->name('opportunities.show');
    Route::post('/opportunities/{id}/apply', 'applyOpportunity')->name('opportunities.apply');
    Route::get('/profile', 'profile')->name('profile');
    Route::get('/profile/edit', 'editProfile')->name('profile.edit');
    Route::put('/profile', 'updateProfile')->name('profile.update');
    Route::get('/change-password', 'changePassword')->name('change-password');
    Route::put('/change-password', 'updatePassword')->name('change-password.update');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->controller(AdminController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/users', 'users')->name('users.index');
    Route::get('/users/{user}', 'showUser')->name('users.show');
    Route::get('/users/{user}/edit', 'editUser')->name('users.edit');
    Route::put('/users/{user}', 'updateUser')->name('users.update');
    Route::delete('/users/{user}', 'deleteUser')->name('users.delete');
    Route::get('/passports', 'passports')->name('passports');
    Route::get('/pages/{page}/edit', 'editPage')->name('pages.edit');
    Route::put('/pages/{page}', 'updatePage')->name('pages.update');
    Route::get('/change-password', 'changePassword')->name('change-password');
    Route::put('/change-password', 'updatePassword')->name('change-password.update');
    //Homepage Settings
            Route::get('/content/homepage', [HomePageController::class, 'editHomepage'])
            ->name('content.homepage');

        Route::post('/content/homepage', [HomePageController::class, 'updateHomepage'])
            ->name('content.homepage.update');


    });
