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

Route::get('/{any}', 'SpaController@index')->where('any', '.*');

// Route::get('/login-google', function () {
//     return Socialite::driver('google')->redirect();
// });

// Route::get('/callback-google', 'AutenticarUsuarioController@google');

// #### Layouts ####

// Route::get('/', function () {
//     return view('login');
// });

// Route::get('/feeds', function () {
//     return view('feeds');
// });

// Route::get('/login', function () {
//     return view('login');
// });

// #### Tailwind UI - Exemplos ####

// Route::get('/exemplo/home', function () {
//     return view('exemplo.home');
// })->name('exemplo.home');

// Route::get('/exemplo/login', function () {
//     return view('exemplo.auth.login');
// })->name('exemplo.login');

// Route::post('/exemplo/auth', function () {
//     return redirect()->route('exemplo.team');
// })->name('exemplo.dummyauth');

// Route::get('/exemplo/teams', function () {
//     return view('exemplo.resources.team');
// })->name('exemplo.team');

// Route::get('/exemplo/teams/detail', function () {
//     return view('exemplo.resources.teamdetail');
// })->name('exemplo.teamdetail');

// Route::get('/exemplo/teams/edit', function () {
//     $applications = ['Backend Engineer', 'Frontend Engineer', 'QA Engineer', 'Project Manager'];
//     $availabilities = ['soon', '1-month', 'closed'];
//     $workingPreferences = ['on site', 'remote'];
//     return view('exemplo.resources.teamedit', compact('applications', 'availabilities', 'workingPreferences'));
// })->name('exemplo.teamedit');
