<?php

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

Route::get('/', function () {
    return view('index');
})->name('home');
Route::get('/checkout', function () {
    return view('shoping');
})->name('finalizar');

Route::get('/produtos', function () {
    return view('produtos');
})->name('produtos');

Route::get('/contato', function () {
    return view('contato');
})->name('contato');


Route::post('/mail',[\App\Http\Controllers\MailController::class,"sendMail"])->name('sendmail');
