<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\Backend\AmenitiesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Backend\PropertyTypeController;
use App\Http\Controllers\Backend\RoleController;

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

require __DIR__ . '/auth.php';

// Admin Group Middleware

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin/dashboard', 'adminDashboard')->name('admin.dashboard');

        Route::get('/admin/logout', 'adminLogout')->name('admin.logout');

        Route::get('/admin/profile', 'adminProfile')->name('admin.profile');

        Route::post('/admin/profile/store', 'adminProfileStore')->name('admin.profile.store');

        Route::get('/admin/change/password', 'adminChangePassword')->name('admin.change.password');

        Route::post('/admin/update/password', 'adminUpdatePassword')->name('admin.update.password');
    });

    // Property Type Controller

    Route::controller(PropertyTypeController::class)->group(function () {

        Route::get('/all/type',  'allType')->name('all.type');
        Route::get('/add/type',  'addType')->name('add.type');
        Route::post('/store/type',  'storeType')->name('store.type');
        Route::get('/delete/type/{id}',  'deleteType')->name('delete.type');
        Route::get('/edit/type/{id}',  'editType')->name('edit.type');
        Route::post('/update/type/{id}',  'updateType')->name('update.type');
    });


    // Amenities Controller

    Route::controller(AmenitiesController::class)->group(function () {

        Route::get('/all/amenities',  'allAmenities')->name('all.amenities');
        Route::get('/add/amenity',  'addAmenity')->name('add.amenity');
        Route::post('/store/amenity',  'storeAmenity')->name('store.amenity');
        Route::get('/delete/amenity/{id}',  'deleteAmenity')->name('delete.amenity');

        Route::get('/edit/amenity/{id}',  'editAmenity')->name('edit.amenity');
        Route::post('/update/amenity/{id}',  'updateAmenity')->name('update.amenity');
    });

    // Permission Controller

    Route::controller(RoleController::class)->group(function () {

        Route::get('/all/permission',  'allPermission')->name('all.permission');
        Route::get('/add/permission',  'addPermission')->name('add.permission');
        Route::post('/store/permission',  'storePermission')->name('store.permission');
        Route::get('/delete/permission/{id}',  'deletePermission')->name('delete.permission');
        Route::get('/edit/permission/{id}',  'editPermission')->name('edit.permission');
        Route::post('/update/permission/{id}',  'updatePermission')->name('update.permission');
        Route::get('/import/permission', 'importPermission')->name('import.permission');
        Route::get('/export/permissions', 'exportPermissions')->name('export');
    });
});

// End Admin Group Middleware


Route::middleware(['auth', 'role:agent'])->group(function () {
    Route::get('/agent/dashboard', [AgentController::class, 'agentDashboard'])->name('agent.dashboard');
});



Route::get('/user/dashboard', [UserController::class, 'userDashboard'])->name('user.dashboard');


Route::get('/admin/login', [AdminController::class, 'adminLogin'])->name('admin.login');


// Admin Group Middleware
/* Route::middleware(['auth', 'role:admin'])->group(function () {

    //Property Type All Route
    Route::controller(PropertyTypeController::class)->group(function () {

        Route::get('/all/type',  'allType')->name('all.type');
        Route::get('/add/type',  'addType')->name('add.type');
        Route::post('/store/type',  'storeType')->name('store.type');
        Route::get('/delete/type/{id}',  'deleteType')->name('delete.type');
        Route::get('/edit/type/{id}',  'editType')->name('edit.type');
        Route::post('/update/type/{id}',  'updateType')->name('update.type');
    });
}); */

/* Route::middleware(['auth', 'role:admin'])->group(function () {

    //Amenities All Route
    Route::controller(PropertyTypeController::class)->group(function () {

        Route::get('/all/amenities',  'allAmenities')->name('all.amenities');
        Route::get('/add/amenity',  'addAmenity')->name('add.amenity');
        Route::post('/store/amenity',  'storeAmenity')->name('store.amenity');
        Route::get('/delete/amenity/{id}',  'deleteAmenity')->name('delete.amenity');

        Route::get('/edit/amenity/{id}',  'editAmenity')->name('edit.amenity');
        Route::post('/update/amenity/{id}',  'updateAmenity')->name('update.amenity');
    });
});
 */