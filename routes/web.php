<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', 'App\Http\Controllers\PagesController@index')->where('any', '.*');
