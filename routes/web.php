<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Models\Tenders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


Route::get('/', function (Request $request) {
    return view('home', ['token' => $request->user()->api_token]);
})->name('home')->middleware('auth');


Route::get('/register', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('register');
})->name('register');

Route::post('/register', [MainController::class, 'register']);


Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('login');
})->name('login');

Route::post('/login', [MainController::class, 'login']);


Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');


Route::get('/update', function () {
    return view('update', ['tenders' => (new Tenders())->all()]);
})->name('update')->middleware('auth');

Route::post('/update', [MainController::class, 'update'])->middleware('auth');
