<?php
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\EriController;
use App\Http\Controllers\Admin\HomePageController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\WorkforcePassportController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomePageController::class, 'showHomepage'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/workforce-passport', [WorkforcePassportController::class, 'workforcePassport'])->name('passport');
Route::get('/eri', [EriController::class, 'index'])->name('eri');
Route::get('/programs', [ProgramController::class, 'index'])->name('programs');
Route::view('/employers', 'pages.employers')->name('employers');
Route::view('/institutions', 'pages.institutions')->name('institutions');
Route::view('/workforce-intelligence', 'pages.workforce-intelligence')->name('intelligence');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/create-passport', [WorkforcePassportController::class, 'workforcePassport'])->name('passport.create');

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
    Route::get('/passports', 'passports')->name('passports.index');
    Route::get('/programs', 'programs')->name('programs.index');

    // Content Management
    Route::get('/content/eri', [EriController::class, 'edit'])->name('content.eri');
    Route::post('/content/eri', [EriController::class, 'update'])->name('content.eri.update');
    Route::get('/content/workforce-passport', [WorkforcePassportController::class, 'edit'])->name('content.workforce-passport');
    Route::post('/content/workforce-passport', [WorkforcePassportController::class, 'update'])->name('content.workforce-passport.update');
    Route::get('/content/programs', [ProgramController::class, 'edit'])->name('content.program');
    Route::post('/content/programs', [ProgramController::class, 'update'])->name('content.program.update');
    Route::post('/content/programs/store', [ProgramController::class, 'store'])->name('content.program.store');
    Route::post('/content/programs/restore', [ProgramController::class, 'restoreDefaults'])->name('content.program.restore');
    Route::get('/content/contact', [ContactController::class, 'edit'])->name('content.contact');
    Route::post('/content/contact', [ContactController::class, 'update'])->name('content.contact.update');
    Route::post('/content/contact/restore', [ContactController::class, 'restore'])->name('content.contact.restore');

    Route::get('/pages/{page}/edit', 'editPage')->name('pages.edit');
    Route::put('/pages/{page}', 'updatePage')->name('pages.update');
    Route::get('/change-password', 'changePassword')->name('change-password');
    Route::put('/change-password', 'updatePassword')->name('change-password.update');
    Route::get('/content/homepage', [HomePageController::class, 'editHomepage'])->name('content.homepage');
    Route::post('/content/homepage', [HomePageController::class, 'updateHomepage'])->name('content.homepage.update');
    Route::post('/content/homepage/restore', [HomePageController::class, 'restoreHomepage'])->name('content.homepage.restore');

   
    // Show About Page form (OPEN PAGE)
    Route::get('content/about', [AboutController::class, 'edit'])
        ->name('content.about');

    // Update About Page (SAVE FORM)
    Route::post('content/about/update', [AboutController::class, 'update'])
        ->name('content.about.update');

    // Optional: Restore defaults
    Route::post('content/about/restore', [AboutController::class, 'restore'])
        ->name('content.about.restore');

        });
