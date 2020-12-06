<?php

namespace App\Services\Mailer;

use App\Models\Mail;
use App\Services\Mailer\MailerGatewayInterface;
use App\Services\Mailer\AlternativeMailerGatewayInterface;
use \SendGrid\Mail\Mail as SendGridMail;
use SendGrid;


class MailJetMailerGateway implements MailerGatewayInterface,AlternativeMailerGatewayInterface{


    private $sendgridService;
    private $emailMessage;


    public function __construct()
    {
        /* $this->sendgridService = new SendGrid(getenv('SENDGRID_API_KEY')); */
    }

    private function prepareMail(Mail $mail){
        $fromEmail = getenv('SENDGRID_FROM_EMAIL');
        $fromName = getenv('SENDGRID_FROM_NAME');

        $this->emailMessage = new SendGridMail();
        $this->emailMessage->setFrom( $fromEmail,$fromName );
        $this->emailMessage->setSubject($mail->title);
        $this->emailMessage->addTo($mail->recipients);
        $this->emailMessage->addContent($mail->content_type, $mail->body);

    }

    public function send(Mail $mail){


        try {
            $this->prepareMail($mail);
            $mail->bounced();
            $this->sendgridService->send($this->emailMessage);
            $mail->delivered();
            print "\n Enviado do MailJet \n";
        } catch (\Exception $e) {
              $mail->failed();
            \Log::error($e->getMessage());
            \Log::error($e->getTraceAsString());
           throw new \Exception($e->getMessage());

        }

    }



}
