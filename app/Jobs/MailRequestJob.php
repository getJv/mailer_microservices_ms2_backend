<?php

namespace App\Jobs;

use App\Models\Mail;
use App\Services\Mailer\AlternativeMailerGatewayInterface;
use App\Services\Mailer\MailerGatewayInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;



class MailRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $mail;

    public function __construct(Mail $mail)
    {
        $this->mail = $mail;
    }


    public function handle(MailerGatewayInterface $mailer ,AlternativeMailerGatewayInterface $alternativeMailer )
    {
        try {
            $mailer->send($this->mail);
        } catch (\Exception $th) {
            $alternativeMailer->send($this->mail);
        }
    }
}
