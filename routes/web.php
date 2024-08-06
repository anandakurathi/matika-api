<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';


Route::get('email/verify/already-success', function () {
    return view('auth/email/verify/already-success');
});

Route::get('email/verify/success', function () {
    return view('auth/email/verify/success');
});

Route::get('email/verify/failed', function () {
    return view('auth/email/verify/failed');
});
