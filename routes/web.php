<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;




Route::get('/', function () {
    return view('splash');
})->name('splash');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome-portal');

Route::get('/signup-portal', function () {
    return view('signup.signup');
})->name('signup-portal');



//Signup Route Process
Route::post('/signup', [SignupController::class, 'store'])->name('signup.store');

//Login Route Process
Route::post('/login-user', [SignupController::class, 'LoginUser'])->name('login.user');

//Logout Route
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('welcome-portal')->with('success', 'Logged out successfully!');
})->name('logout');

//User Dashboard
Route::get('/user-dashboard', [UserController::class, 'dashboard'])
    ->middleware('auth')
    ->name('user.dashboard');

//Admin Dashboard
Route::get('/admin-portal', function () {
    return view('home.admin');
})->middleware(['auth', 'admin'])->name('home.admin');


Route::get('/dashboard', [AdminController::class, 'indigency'])
    ->middleware(['auth', 'admin'])
    ->name('dashboard.portal');


Route::get('/add-user', function () {
    return view('portals.add-user');
})->middleware(['auth', 'admin'])->name('add-user.portal');

Route::get('/agri-dashboard', function () {
    return view('portals.agriculture-cert');
})->middleware(['auth', 'admin'])->name('dashboard.agriculture');


Route::get('/residents', [AdminController::class, 'residentsList'])
    ->middleware(['auth', 'admin'])
    ->name('dashboard-residents.residents');

Route::get('/document-requests', [AdminController::class, 'documentRequests'])
    ->middleware(['auth', 'admin'])
    ->name('dashboard.document-requests');

Route::get('/document-request/{id}', [AdminController::class, 'showDocumentRequest'])
    ->middleware(['auth', 'admin'])
    ->name('document-request.show');

Route::get('/barangay-certification', function () {
    return view('portals.barangay-certification');
})->middleware(['auth', 'admin'])->name('dashboard.barangay-certification');

Route::get('/business-certification', function () {
    return view('portals.business-certification');
})->middleware(['auth', 'admin'])->name('dashboard.business-certification');

Route::get('/good-moral-certification', function () {
    return view('portals.good-moral-certification');
})->middleware(['auth', 'admin'])->name('dashboard.good-moral-certification');




Route::get('/events-display', [EventsController::class, 'EventDisplay'])->name('events.index');
