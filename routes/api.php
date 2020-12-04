<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Jobs\MailRequestJob;

Route::resources([
    'mails' => MailController::class,
]);



