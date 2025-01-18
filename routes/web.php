<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Backend\PropertyTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Admin Group Middleware

Route::middleware(['auth', 'role:admin'])->group(function(){

    Route::controller(AdminController::class)->group(function(){
        Route::get('/admin/dashboard',  'adminDashboard')->name('admin.dashboard');

        Route::get('/admin/logout',  'adminLogout')->name('admin.logout');
    
        Route::get('/admin/profile',  'adminProfile')->name('admin.profile');
    
        Route::post('/admin/profile/store',  'adminProfileStore')->name('admin.profile.store');
    
        Route::get('/admin/change/password',  'adminChangePassword')->name('admin.change.password');
    
        Route::post('/admin/update/password',  'adminUpdatePassword')->name('admin.update.password');
    });

    
});

// End Admin Group Middleware


Route::middleware(['auth', 'role:agent'])->group(function(){
Route::get('/agent/dashboard', [AgentController::class, 'agentDashboard'])->name('agent.dashboard');
 });



Route::get('/user/dashboard', [UserController::class, 'userDashboard'])->name('user.dashboard');


Route::get('/admin/login', [AdminController::class, 'adminLogin'])->name('admin.login');


// Admin Group Middleware
Route::middleware(['auth', 'role:admin'])->group(function(){

//Property Type All Route
    Route::controller(PropertyTypeController::class)->group(function(){

        Route::get('/all/type', 'allType')->name('all.type');

    });

    
});