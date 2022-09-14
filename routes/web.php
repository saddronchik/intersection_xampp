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



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['role:user_сitisen|admin']], function () {
    Route::get('/citisenuser', [App\Http\Controllers\HomeController::class, 'indexcitisen'])->name('homeuser');
    Route::get('/search', [App\Http\Controllers\HomeController::class, 'search'])->name('search');
    Route::get('/searchUsers', [App\Http\Controllers\HomeController::class, 'searchUsers'])->name('searchUsers');

    Route::get('/citisen/{id}', [App\Http\Controllers\CitisenControl::class, 'show'])->name('citisen.show');
    Route::get('citisen/citisenBorder/{id}', [App\Http\Controllers\CitisenControl::class, 'showBorderCitisen']);
    Route::get('/citisens/exports', [App\Services\CitisensServices::class, 'CitisenExport'])->name('citisen.export');


    Route::get('/searchPeople', [App\Http\Controllers\PeoplesController::class, 'searchPeople'])->name('searchPeople');
    Route::get('/searchPeopleUser', [App\Http\Controllers\PeoplesController::class, 'searchPeopleUser'])->name('searchPeopleUser');

    Route::get('/people/index', [App\Http\Controllers\PeoplesController::class, 'index'])->name('people.index');
    Route::get('/peopleuser', [App\Http\Controllers\PeoplesController::class, 'indexUser'])->name('peopleuser');
    Route::get('/people/{id}', [App\Http\Controllers\PeoplesController::class, 'show']);

});

Route::group(['middleware' => ['role:user_сitisen_add|admin']], function () {

    Route::get('/citizen/create', [App\Http\Controllers\CitisenControl::class, 'create'])->name('citizen.create');

    Route::post('/citizen', [App\Http\Controllers\CitisenControl::class, 'store'])->name('citizen.store');
    Route::post('/citisens/import', [App\Services\CitisensServices::class, 'CitisenImport'])->name('citisen.import');
    Route::post('/citisens/importNoHead', [App\Services\CitisensServices::class, 'CitisenImportNoHead']);
    Route::get('/destroyCitisen/{id}', [App\Http\Controllers\CitisenControl::class, 'destroy']);
});

Route::group(['prefix' => 'people', 'as' => 'people.', 'middleware' => ['role:user_сitisen_add|admin']], function () {
    Route::get('/create', [App\Http\Controllers\PeoplesController::class, 'create'])->name('create');
    Route::post('/store', [App\Http\Controllers\PeoplesController::class, 'store'])->name('store');
    Route::get('/destroy/{id}', [App\Http\Controllers\PeoplesController::class, 'destroy'])->name('destroy');
});

Route::group(['middleware' => ['role:user_сitisen_upd|admin']], function () {
    Route::post('/citisen/{id}', [App\Http\Controllers\CitisenControl::class, 'update'])->name('citisen');
    Route::post('/people/{id}', [App\Http\Controllers\PeoplesController::class, 'update'])->name('people');
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





Route::group(['middleware' => ['role:user_border|admin']], function () {
    Route::get('/searchBorders', [App\Http\Controllers\BorderController::class, 'searchBorders'])->name('searchBorders');
    Route::get('/searchBordersUser', [App\Http\Controllers\BorderController::class, 'searchBordersUser'])->name('searchBordersUser');
    Route::get('/borderslist', [App\Http\Controllers\BorderController::class, 'index'])->name('borders.list');
    Route::get('/borderslistUser', [App\Http\Controllers\BorderController::class, 'indexUser']);
    // Route::get('/addborder', [App\Http\Controllers\BorderController::class, 'indexAdd']);

    // Route::get('/addavtos', [App\Http\Controllers\BorderController::class, 'indexAvtos']);
    Route::get('/border/{id}', [App\Http\Controllers\BorderController::class, 'show']);

    Route::get('/borders/exports', [App\Services\BordersServices::class, 'BordersExport']);

});

Route::group(['middleware' => ['role:user_border_add|admin']], function () {
    Route::post('/borders', [App\Http\Controllers\BorderController::class, 'store']);
    Route::get('/addborder', [App\Http\Controllers\BorderController::class, 'indexa']);
    Route::get('/destroyborder/{id}', [App\Http\Controllers\BorderController::class, 'destroy']);
    Route::post('/borders/import', [App\Services\BordersServices::class, 'BordersImport']);
});
Route::group(['middleware' => ['role:user_border_upd|admin']], function () {
    Route::post('/border/{id}', [App\Http\Controllers\BorderController::class, 'update'])->name('border.update');
});


Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/logs', [App\Http\Controllers\LogController::class, 'show']);

    Route::get('/usersList', [App\Http\Controllers\UsersController::class, 'index'])->name('usersList');

    Route::get('/addusers', [App\Http\Controllers\UsersController::class, 'indexUser']);
    Route::post('/users', [App\Http\Controllers\UsersController::class, 'store']);

    Route::get('/users/{id}', [App\Http\Controllers\UsersController::class, 'show']);
    Route::post('/users/{id}', [App\Http\Controllers\UsersController::class, 'update'])->name('update.user');
    Route::get('/destroyuser/{id}', [App\Http\Controllers\UsersController::class, 'destroy']);
});





