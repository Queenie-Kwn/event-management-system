<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\AdminController;




Route::get('/', function () {
    return view('welcome');
})->name('welcome-portal');

Route::get('/signup-portal', function () {
    return view('signup.signup');
})->name('signup-portal');



//Signup Route Process
Route::post('/signup', [SignupController::class, 'store'])->name('signup.store');

//Admin Login Route Process
Route::post('/login-user', [SignupController::class, 'LoginUser'])->name('login.user');

//Dashboard
Route::get('/admin-portal', function () {
    return view('home.admin');
})->name('home.admin');


Route::get('/dashboard', [AdminController::class, 'indigency'])
    ->name('dashboard.portal');


Route::get('/add-user', function () {
    return view('portals.add-user');
})->name('add-user.portal');

Route::get('/agri-dashboard', function () {
    return view('portals.agriculture-cert');
})->name('dashboard.agriculture');


Route::get('/residents', [AdminController::class, 'residentsList'])
    ->name('dashboard-residents.residents');

Route::get('/document-requests', [AdminController::class, 'documentRequests'])
    ->name('dashboard.document-requests');

Route::get('/document-request/{id}', [AdminController::class, 'showDocumentRequest'])
    ->name('document-request.show');

Route::get('/barangay-certification', function () {
    return view('portals.barangay-certification');
})->name('dashboard.barangay-certification');

Route::get('/business-certification', function () {
    return view('portals.business-certification');
})->name('dashboard.business-certification');

Route::get('/good-moral-certification', function () {
    return view('portals.good-moral-certification');
})->name('dashboard.good-moral-certification');




Route::get('/events-display', [EventsController::class, 'EventDisplay'])->name('events.index');
