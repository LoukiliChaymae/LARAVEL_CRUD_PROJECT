<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
include 'api/auth.php';
include 'api/product.php';



Route::get('/hello', function () {
    return 'Hello, World!';
});
//localhost/api/
