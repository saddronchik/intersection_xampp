<?php

use Illuminate\Support\Facades\Route;

use App\Notifications\Users;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/viewMessages', [App\Http\Controllers\HomeController::class, 'viewMessages'])->name('viewMessages');
Route::get('/listmessage/{id}', [App\Http\Controllers\HomeController::class, 'showmessages']);
Route::post('/message', [App\Http\Controllers\HomeController::class, 'sendMessage']);


Route::get('/home', [App\Http\Controllers\EventsController::class, 'index'])->name('home');

Route::group(['prefix'=>'citizen','as'=>'citizen.'],function(){

    Route::group(['middleware' => ['role:user_сitisen|admin']], function () {
        Route::get('/citisenuser', [App\Http\Controllers\HomeController::class, 'citizenForUser'])->name('citizenForUser');
        Route::get('/search', [App\Http\Controllers\HomeController::class, 'search'])->name('search');
        Route::get('/searchUsers', [App\Http\Controllers\HomeController::class, 'searchUsers'])->name('searchUsers');
        Route::get('/citizenList', [App\Http\Controllers\HomeController::class, 'сitizesList'])->name('list');
        Route::get('/citisen/{id}', [App\Http\Controllers\CitisenControl::class, 'show'])->name('show');
        Route::get('citisen/citisenBorder/{id}', [App\Http\Controllers\CitisenControl::class, 'showBorderCitisen']);
        Route::get('/citisens/exports', [App\Services\CitisensServices::class, 'CitisenExport'])->name('export');
    });
    Route::group(['middleware' => ['role:user_сitisen_add|admin']], function () {
        Route::get('/citizen/create', [App\Http\Controllers\CitisenControl::class, 'create'])->name('create');
        Route::post('/citizen', [App\Http\Controllers\CitisenControl::class, 'store'])->name('store');
        Route::post('/citisens/import', [App\Services\CitisensServices::class, 'CitisenImport'])->name('import');
        Route::post('/citisens/importNoHead', [App\Services\CitisensServices::class, 'CitisenImportNoHead']);
        Route::get('/destroyCitisen/{id}', [App\Http\Controllers\CitisenControl::class, 'destroy']);
    });
    Route::group(['middleware' => ['role:user_сitisen_upd|admin']], function () {
        Route::post('/citisen/{id}', [App\Http\Controllers\CitisenControl::class, 'update'])->name('update');
    });

});

Route::group(['prefix'=>'event','as'=>'events.'],function(){

    Route::get('/searchEvent', [App\Http\Controllers\EventsController::class, 'searchEvent'])->name('search');
    Route::get('/searchEventForUser', [App\Http\Controllers\EventsController::class, 'searchEventForUser'])->name('searchForUser');
    Route::get('/eventsAdd',[App\Http\Controllers\EventsController::class,'create'])->name('create');
    Route::post('/eventStore',[App\Http\Controllers\EventsController::class,'store'])->name('store');
    Route::get('/destroyEvent/{id}', [App\Http\Controllers\EventsController::class, 'delete'])->name('destroy');
    Route::post('/event/{id}', [App\Http\Controllers\EventsController::class, 'update'])->name('update');
    Route::get('/event/{id}', [App\Http\Controllers\EventsController::class, 'show'])->name('show');

});

Route::group(['prefix' => 'auto', 'as' => 'auto.'], function () {

    Route::group(['middleware' => ['role:user_avto|admin']], function () {
        Route::get('/searchAvto', [App\Http\Controllers\AutoController::class, 'search'])->name('search');
        Route::get('/searchAvtoUser', [App\Http\Controllers\AutoController::class, 'searchAutoUser'])->name('search-by-user');
        Route::get('/index', [App\Http\Controllers\AutoController::class, 'index'])->name('index');
        Route::get('/available', [App\Http\Controllers\AutoController::class, 'listByUser'])->name('available');
        Route::get('/create', [App\Http\Controllers\AutoController::class, 'create'])->name('create');
        Route::get('/{id}', [App\Http\Controllers\AutoController::class, 'show'])->name('show');
        Route::get('/border/{id}', [App\Http\Controllers\AutoController::class, 'showBorderAutos']);
        Route::get('/autos/exports', [App\Services\AutoServices::class, 'export'])->name('export');
    });

    Route::group([['middleware' => ['role:user_avto_add|admin']]], function () {
        Route::post('/avtos', [App\Http\Controllers\AutoController::class, 'store'])->name('store');
        Route::post('/avtos/import', [App\Services\AutoServices::class, 'import'])->name('import');
        Route::get('/destroy/{id}', [App\Http\Controllers\AutoController::class, 'destroy']);
    });

    Route::group(['middleware' => ['role:user_avto_upd|admin']], function () {
        Route::post('/auto/{id}', [App\Http\Controllers\AutoController::class, 'update'])->name('update');
    });
});


Route::group(['prefix' => 'borders', 'as' => 'borders.'],function(){

    Route::group(['middleware' => ['role:user_border|admin']], function () {
        Route::get('/searchBorders', [App\Http\Controllers\BorderController::class, 'searchBorders'])->name('search');
        Route::get('/searchBordersUser', [App\Http\Controllers\BorderController::class, 'searchBordersUser'])->name('searchUser');
        Route::get('/borderslist', [App\Http\Controllers\BorderController::class, 'index'])->name('list');
        Route::get('/borderslistUser', [App\Http\Controllers\BorderController::class, 'indexUser'])->name('list.user');
        Route::get('/border/{id}', [App\Http\Controllers\BorderController::class, 'show'])->name('show');
        Route::get('/borders/exports', [App\Services\BordersServices::class, 'BordersExport'])->name('export');
    });

    Route::group(['middleware' => ['role:user_border_add|admin']], function () {
        Route::post('/borders', [App\Http\Controllers\BorderController::class, 'store'])->name('store');
        Route::get('/addborder', [App\Http\Controllers\BorderController::class, 'create'])->name('create');
        Route::get('/destroyborder/{id}', [App\Http\Controllers\BorderController::class, 'destroy'])->name('destroy');
        Route::post('/borders/import', [App\Services\BordersServices::class, 'BordersImport'])->name('import');
    });
    Route::group(['middleware' => ['role:user_border_upd|admin']], function () {
        Route::post('/border/{id}', [App\Http\Controllers\BorderController::class, 'update'])->name('update');
    });
});

Route::group(['prefix' => 'user', 'as' => 'users.'],function(){

    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/usersList', [App\Http\Controllers\UsersController::class, 'index'])->name('list');
        Route::get('/addusers', [App\Http\Controllers\UsersController::class, 'indexUser'])->name('create');
        Route::post('/users', [App\Http\Controllers\UsersController::class, 'store'])->name('store');
        Route::get('/users/{id}', [App\Http\Controllers\UsersController::class, 'show'])->name('name');
        Route::post('/users/{id}', [App\Http\Controllers\UsersController::class, 'update'])->name('update');
        Route::post('/userPass/{id}', [App\Http\Controllers\UsersController::class, 'updatePassword'])->name('updatePass');
        Route::get('/destroyuser/{id}', [App\Http\Controllers\UsersController::class, 'destroy'])->name('destroy');
    });
});

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/logs', [App\Http\Controllers\LogController::class, 'show'])->name('logs');
});

