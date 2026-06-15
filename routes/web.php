<?php
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\EriController;
use App\Http\Controllers\Admin\EmployerController;
use App\Http\Controllers\Admin\HomePageController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\WorkforcePassportController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserManagementController; // Import the UserManagementController

Route::get('/', [HomePageController::class, 'showHomepage'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/workforce-passport', [WorkforcePassportController::class, 'workforcePassport'])->name('passport');
Route::get('/eri', [EriController::class, 'index'])->name('eri');
Route::get('/programs', [ProgramController::class, 'index'])->name('programs');
Route::view('/employers', 'pages.employers')->name('employers');
Route::view('/institutions', 'pages.institutions')->name('institutions');
Route::view('/workforce-intelligence', 'pages.workforce-intelligence')->name('intelligence');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::get('/create-passport', [WorkforcePassportController::class, 'workforcePassport'])->name('passport.create');

// Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', 'showLogin')->name('login');
        Route::post('/login', 'login')->name('login.store');
        Route::get('/register', 'showRegister')->name('register');
        Route::post('/register', 'register')->name('register.store');
        Route::get('/register/employer', [AuthController::class, 'showEmployerRegister'])->name('register.employer');
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

// Employer Routes
Route::middleware(['auth', 'role:employer'])->prefix('employer')->name('employer.')->group(function () {
    Route::get('/dashboard', function () {
        return view('employer.dashboard');
    })->name('dashboard');
    Route::resource('jobs', \App\Http\Controllers\Employer\JobPostingController::class);
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->controller(AdminController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard');

    // User Management routes using UserManagementController
    Route::controller(UserManagementController::class)->group(function () {
        Route::get('/users', 'index')->name('users.index');
        Route::get('/users/create', 'create')->name('users.create'); // Added route
        Route::post('/users', 'store')->name('users.store'); // Added route
        Route::get('/users/{user}', 'show')->name('users.show'); // Mapped to UserManagementController@show
        Route::get('/users/{user}/edit', 'edit')->name('users.edit');
        Route::put('/users/{user}', 'update')->name('users.update');
        Route::delete('/users/{user}', 'destroy')->name('users.delete');
    });
    Route::get('/passports', 'passports')->name('passports.index');

    // Employer Management
    Route::get('/employers', [EmployerController::class, 'index'])->name('employers.index');
    Route::get('/employers/create', [EmployerController::class, 'create'])->name('employers.create');
    Route::post('/employers', [EmployerController::class, 'store'])->name('employers.store');
    Route::get('/employers/{employer}/edit', [EmployerController::class, 'edit'])->name('employers.edit');
    Route::put('/employers/{employer}', [EmployerController::class, 'update'])->name('employers.update');
    Route::post('/employers/{employer}/approve', [EmployerController::class, 'approve'])->name('employers.approve');
    Route::delete('/employers/{employer}', [EmployerController::class, 'destroy'])->name('employers.destroy');

    // Job Management
    Route::get('/jobs', 'jobsIndex')->name('jobs.index');
    Route::get('/jobs/create', 'createJob')->name('jobs.create');
    Route::post('/jobs', 'storeJob')->name('jobs.store');
    Route::get('/jobs/{job}/edit', 'editJob')->name('jobs.edit'); // Corrected route parameter name
    Route::put('/jobs/{job}', 'updateJob')->name('jobs.update');
    Route::delete('/jobs/{job}', 'destroyJob')->name('jobs.destroy');

    Route::get('/programs', 'programs')->name('programs.index');

    // Content Management
    Route::get('/content/eri', [EriController::class, 'edit'])->name('content.eri');
    Route::post('/content/eri', [EriController::class, 'update'])->name('content.eri.update');
    Route::get('/content/workforce-passport', [WorkforcePassportController::class, 'edit'])->name('content.workforce-passport');
    Route::post('/content/workforce-passport', [WorkforcePassportController::class, 'update'])->name('content.workforce-passport.update');
    Route::get('/content/programs', [ProgramController::class, 'edit'])->name('content.program');
    Route::post('/content/programs', [ProgramController::class, 'update'])->name('content.program.update');
    Route::get('/content/programs/{program}/edit', [ProgramController::class, 'editSingle'])->name('content.program.edit-single');
    Route::put('/content/programs/{program}', [ProgramController::class, 'updateSingle'])->name('content.program.update-single');
    Route::delete('/content/programs/{program}', [ProgramController::class, 'delete'])->name('content.program.delete');
    Route::post('/content/programs/store', [ProgramController::class, 'store'])->name('content.program.store');
    Route::post('/content/programs/restore', [ProgramController::class, 'restoreDefaults'])->name('content.program.restore');
    Route::get('/content/contact', [ContactController::class, 'edit'])->name('content.contact');
    Route::post('/content/contact', [ContactController::class, 'update'])->name('content.contact.update');
    Route::get('/contact-submissions', [ContactController::class, 'submissions'])->name('contact.submissions');
    Route::delete('/contact-submissions/{submission}', [ContactController::class, 'destroySubmission'])->name('contact.submissions.delete');
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
