<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(url('/admin'));
});

require __DIR__.'/auth.php';
