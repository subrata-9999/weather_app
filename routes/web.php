<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

Route::get('/', function () {
    return view('weather');
});

Route::post('/get-weather', [WeatherController::class, 'getWeather'])->name('getWeather');
