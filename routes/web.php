<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AppliedJobController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobListController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AuthenticateUser;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Auth routes
Route::prefix('account')->name('account.')->middleware([AuthenticateUser::class])->group(function () {
    Route::get('/login', [AccountController::class, 'login'])->name('login');
    Route::post('/login', [AccountController::class, 'loginUser'])->name('loginUser');
    Route::get('/register', [AccountController::class, 'register'])->name('register');
    Route::post('/register', [AccountController::class, 'registerUser'])->name('registerUser');
    Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
    Route::put('/profile', [AccountController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/profile-pic', [AccountController::class, 'updateProfilePic'])->name('updateProfilePic');
    Route::get('/logout', [AccountController::class, 'logout'])->name('logout');
    Route::post('/change-password', [AccountController::class, 'changePassword'])->name('changePassword');
});

Route::prefix('job')->name('job.')->middleware([AuthenticateUser::class])->group(function () {
    Route::get('/post', [JobListController::class, 'index'])->name('job');
    Route::post('/post', [JobListController::class, 'createJob'])->name('createJob');
    Route::get('/my-jobs', [JobListController::class, 'myJobs'])->name('myJobs');
    Route::get('/archive-jobs', [JobListController::class, 'archiveJobs'])->name('archiveJobs');
    Route::post('/archive-job/{id}', [JobListController::class, 'expireJob'])->name('expireJob');
    Route::delete('/{id}', [JobListController::class, 'delJob'])->name('delJob');
    Route::get('/jobs-applied', [JobListController::class, 'appliedJob'])->name('appliedJob');
});

Route::prefix('apply')->name('jobapplied.')->middleware([AuthenticateUser::class])->group(function () {
    Route::get('/', [AppliedJobController::class, 'appliedJob'])->name('appliedJob');
});

Route::name('company.')->middleware([AuthenticateUser::class])->group(function () {
    Route::get('/all-companies', [CompanyController::class, 'allCompanies'])->name('allCompanies');
    Route::post('/add-company', [CompanyController::class, 'addCompany'])->name('addCompany');
    Route::get('/company/{id}', [CompanyController::class, 'getCompany'])->name('getCompany');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
