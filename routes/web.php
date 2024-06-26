<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [TaskController::class, 'index'])->name('home');

Route::get('/register', [SessionsController::class, 'create']);
Route::post('/register', [SessionsController::class, 'store'])->name('sessions.store');
Route::get('/login', [SessionsController::class, 'createLogin']);
Route::post('/login', [SessionsController::class, 'login'])->name('sessions.login');
Route::post('/logout', [SessionsController::class, 'destroy']);

Route::patch('/task/{task}/completed', [TaskController::class,'completed']);
Route::post('/task/{task}/comment', [CommentController::class, 'store']);
Route::get('/task/{task}/notify', [TaskController::class, 'notifyUser']);
Route::get('task/{task}/edit', [TaskController::class, 'edit'])->name('task.edit');
Route::patch('task/{task}', [TaskController::class, 'update'])->name('task.update');


Route::get('user/admin/dashboard', [UserController::class, 'adminDashboard'])->name('admin.dashboard');
Route::get('user/{user}/dashboard', [UserController::class, 'userDashboard'])->name('user.dashboard');

Route::get('/profile', [UserController::class, 'showProfile'])->name('user.profile');
Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('user.edit-profile');
Route::post('/profile/edit', [UserController::class, 'updateProfile'])->name('user.update-profile');
Route::post('/profile/password', [UserController::class, 'updatePassword'])->name('profile.update.password');

Route::resources([
    'task' => TaskController::class,
    'user'=> UserController::class,
]);
