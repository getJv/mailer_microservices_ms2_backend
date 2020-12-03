<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mail;
use App\Http\Resources\Mail as MailResource;

class MailController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'title'        => 'required',
            'recipients'   => 'required',
            'content_type' => 'required',
            'body'         => 'required',
        ]);

        $mail = Mail::create($data);
        return new MailResource($mail);
    }
}