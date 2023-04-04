<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect(route('dashboard.index'));
})->name('dashboard');

Route::group(['prefix' => Config::get('app.backend_path'), 'middleware' => ['auth','agent']], function () {
    
    /* dashboard */
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard.index');
    });
    
    /* permission */
    Route::controller(PermissionController::class)->group(function () {
        Route::get('/permission', 'index')->name('permission.index')->middleware('permission:List Permission');
        Route::get('/permission/list', 'getList')->name('permission.list')->middleware('permission:List Permission');
    });

    /* role */
    Route::controller(RoleController::class)->group(function () {
        Route::get('/role', 'index')->name('role.index')->middleware('permission:List Role');
        Route::get('/role/list', 'getList')->name('role.list')->middleware('permission:List Role');
        Route::get('/role/create', 'create')->name('role.create')->middleware('permission:Create Role');
        Route::post('/role/store', 'store')->name('role.store')->middleware('permission:Create Role');
        Route::get('/role/show/{id}', 'show')->name('role.show')->middleware('permission:View Role');
        Route::get('/role/edit/{id}', 'edit')->name('role.edit')->middleware('permission:Update Role');
        Route::put('/role/update/{id}', 'update')->name('role.update')->middleware('permission:Update Role');
        Route::delete('/role/delete/{id}', 'destroy')->name('role.destroy')->middleware('permission:Delete Role');
    });

    /* user */
    Route::controller(UserController::class)->group(function () {
        Route::get('/user', 'index')->name('user.index')->middleware('permission:List User');
        Route::get('/user/list', 'getList')->name('user.list')->middleware('permission:List User');
        Route::get('/user/create', 'create')->name('user.create')->middleware('permission:Create User');
        Route::post('/user/store', 'store')->name('user.store')->middleware('permission:Create User');
        Route::get('/user/show/{id}', 'show')->name('user.show')->middleware('permission:View User');
        Route::get('/user/edit/{id}', 'edit')->name('user.edit')->middleware('permission:Update User');
        Route::put('/user/update/{id}', 'update')->name('user.update')->middleware('permission:Update User');
        Route::delete('/user/delete/{id}', 'destroy')->name('user.destroy')->middleware('permission:Delete User');
        Route::get('/user/edit/password/{id}', 'editPassword')->name('user.editpassword')->middleware('permission:Update User');
        Route::put('/user/update/password/{id}', 'updatePassword')->name('user.updatepassword')->middleware('permission:Update User');
        Route::get('/user/impersonate/{id}', 'TakeImpersonate')->name('user.takeimpersonate')->middleware('permission:Impersonate User');
        Route::get('/user/revertimpersonate', 'LeaveImpersonate')->name('user.leaveimpersonate');
    });

    /* setting */
    Route::controller(SettingController::class)->group(function () {
        Route::get('/setting/ga', 'EditGA')->name('setting.ga.edit')->middleware('permission:Analytics Setting');
        Route::put('/setting/ga', 'UpdateGA')->name('setting.ga.update')->middleware('permission:Analytics Setting');
        Route::get('/setting/announce', 'EditAnnounce')->name('setting.announce.edit')->middleware('permission:Announcement Setting');
        Route::put('/setting/announce', 'UpdateAnnounce')->name('setting.announce.update')->middleware('permission:Announcement Setting');
        Route::get('/setting/maintenance', 'EditMaintenance')->name('setting.maintenance.edit')->middleware('permission:Maintenance Setting');
        Route::put('/setting/maintenance', 'UpdateMaintenance')->name('setting.maintenance.update')->middleware('permission:Maintenance Setting');
        Route::get('/setting/password', 'EditPassword')->name('setting.password.edit')->middleware('permission:Password Setting');
        Route::put('/setting/password', 'UpdatePassword')->name('setting.password.update')->middleware('permission:Password Setting');
        Route::get('/setting/header', 'EditHeader')->name('setting.header.edit')->middleware('permission:Header Setting');
        Route::put('/setting/header', 'UpdateHeader')->name('setting.header.update')->middleware('permission:Header Setting');
        Route::get('/setting/agent', 'EditAgent')->name('setting.agent.edit')->middleware('permission:Agent Setting');
        Route::put('/setting/agent', 'updateAgent')->name('setting.agent.update')->middleware('permission:Agent Setting');
    });

    /* profile */
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'EditProfile')->name('profile.edit');
        Route::put('/profile', 'UpdateProfile')->name('profile.update');
        Route::get('/profile/password', 'EditPassword')->name('passwd.edit');
        Route::put('/profile/password', 'UpdatePassword')->name('passwd.update');
        Route::get('/profile/picture', 'EditPicture')->name('picture.edit');
        Route::put('/profile/picture', 'UpdatePicture')->name('picture.update');
    });
});

require __DIR__.'/auth.php';
