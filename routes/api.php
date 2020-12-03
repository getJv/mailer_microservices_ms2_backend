<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;

Route::resources([
    'mails' => MailController::class,
]);
