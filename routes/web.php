<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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
use App\Models\Admin;
use App\Notifications\AdminCreatedNotification;

Route::get('bb-logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
Route::get('/', function () {
    return view('welcome');
});


// Catch all route for React
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');