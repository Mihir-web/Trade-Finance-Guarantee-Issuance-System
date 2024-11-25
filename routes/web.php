<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuaranteeController;


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

// Route::get('/', function () {
//     return view('welcome');
// })->name('homepage');



// Admin routes
Route::group(['prefix' => '/'], function () {
Auth::routes();
});

Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::group(['prefix' => '/','middleware' => 'is_admin'], function () {
  
// Route::get('home', [HomeController::class, 'adminHome'])->name('adminHome');

Route::group(['middleware' => 'is_reviewer'], function () {

    Route::get('/guarantee',[GuaranteeController::class, 'index'])->name('guarantees');
    

    Route::group(['middleware' => 'is_mp'], function () {    

        Route::get('/guarantee/create',[GuaranteeController::class, 'create'])->name('guaranteeCreate');
        Route::post('/guarantee/create',[GuaranteeController::class, 'store'])->name('guaranteeStore');
        Route::get('/guarantee/update/{id}',[GuaranteeController::class, 'edit'])->name('guaranteeEdit');
        Route::post('/guarantee/update',[GuaranteeController::class, 'update'])->name('guaranteeUpdate');
        Route::post('/guarantee/delete',[GuaranteeController::class, 'delete'])->name('guaranteeDelete');
        Route::post('/guarantee/statusChange',[GuaranteeController::class, 'statuschange'])->name('guaranteeStatusChange');
        
        Route::group(['middleware' => 'is_superadmin'], function () {
            Route::get('guarantees/import', [GuaranteeController::class, 'importForm'])->name('guaranteeimportForm');
            Route::post('guarantees/import', [GuaranteeController::class, 'import'])->name('guaranteeimport');
           
});


});
});
});