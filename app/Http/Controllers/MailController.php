<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mail;
use App\Http\Resources\Mail as MailResource;
use App\Http\Resources\MailCollection;
use App\Jobs\MailRequestJob;
use Log;

class MailController extends Controller
{
    private $content_type_options = ['markdown','richText','plainText'];

    public function store()
    {

        $data = request()->validate([
            'title'        => 'required',
            'recipients'   => 'required',
            'content_type' => 'required|in:'.implode(',', $this->content_type_options),
            'body'         => 'required',
        ]);

        $mail = Mail::create($data);

        MailRequestJob::dispatch($mail);
        return new MailResource($mail);
    }

    public function update(Mail $mail)
    {
        $data = request()->validate([
            'title'        => 'sometimes|required',
            'recipients'   => 'sometimes|required',
            'content_type' => 'sometimes|required|in:'.implode(',', $this->content_type_options),
            'body'         => 'sometimes|required',

        ]);
        $mail->update($data);
        return new MailResource($mail);
    }

    public function index()
    {
        return new MailCollection(Mail::orderBy('id','desc')->get());
    }

    public function show(Mail $mail)
    {
        return new MailResource($mail);
    }
}
