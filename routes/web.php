<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Controllers\CatController;
// use App\Http\Controllers\User\Auth;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Teacher\TeacherController;
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



Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('user')->name('user.')->group(function(){

    Route::middleware(['guest:web','PreventBackHistory'])->group(function(){
          Route::view('/login','dashboard.user.login')->name('login');
          Route::view('/register','dashboard.user.register')->name('register');
          Route::post('/create',[UserController::class,'register'])->name('register');
          Route::post('/check',[UserController::class,'check'])->name('check');
    });

    Route::middleware(['auth:web','PreventBackHistory'])->group(function(){
          Route::view('/home','dashboard.user.home')->name('home');

          Route::post('/logout',[UserController::class,'logout'])->name('logout');
          Route::get('/add-new',[UserController::class,'add'])->name('add');
    });

});

Route::prefix('admin')->name('admin.')->group(function(){

    Route::middleware(['guest:admin','PreventBackHistory'])->group(function(){
          Route::view('/login','dashboard.admin.login')->name('login');
          Route::post('/check',[AdminController::class,'check'])->name('check');
    });

    Route::middleware(['auth:admin','PreventBackHistory'])->group(function(){
         Route::get('/home',[UserController::class,'show'])->name('home');
        Route::post('/logout',[AdminController::class,'logout'])->name('logout');
        // Route::view('/newUser','dashboard.admin.addUser')->name('newUser');
        Route::get('/newUser',[UserController::class,'createUser'])->name('newUser');
        Route::post('/addUser',[UserController::class,'create'])->name('addUser');
        Route::get('/add/{user}',[UserController::class,'add'])->name('add');
        // Route::view('/edit','dashboard.admin.edit')->name('edit');
        Route::get('/edit',[UserController::class,'editUser'])->name('edit');
        Route::get('/bulkSms',[MessageController::class,'index'])->name('messageList');
        Route::post('/logout',[AdminController::class,'logout'])->name('logout');
        Route::post('send/sms',[MessageController::class,'send'])->name('send');
        Route::resource('user',UserController::class);
        Route::resource('cat',CatController::class);




        // Route::get('/user/{id}', [UserController::class, 'show'])->name('show');
        // Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('destroy');
        // Route::post('/user/{id}', [UserController::class, 'edit'])->name('edit');
        // Route::post('/user/{id}', [UserController::class, 'update'])->name('update');







        //  Route::get('/create', 'UsersController@create')->name('users.create');
            // Route::post('/create', 'UsersController@store')->name('users.store');



    });

});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
   Route::get('/', function(){
            return view ('welcome');
        });
