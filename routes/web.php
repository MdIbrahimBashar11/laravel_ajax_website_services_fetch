<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
 use App\Http\controllers\WebsiteController;

Route::get('/', function () {
    return view('welcome');
});



Route::post('/fetch-services', [WebsiteController::class, 'fetchServices'])->name('url.fetch-services');