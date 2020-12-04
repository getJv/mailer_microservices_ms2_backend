<?php

namespace App\Jobs;

use App\Models\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MailRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $tries = 5;
    private $mailMessage;

    public function __construct(Mail $mail)
    {

        $this->mailMessage = $mail;
    }


    public function handle()
    {
        dump('Email sent!!!!!');
        dump($this->mailMessage);
        dump('end--dump');
    }
}
