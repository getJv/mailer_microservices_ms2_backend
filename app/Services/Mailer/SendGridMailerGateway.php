<?php

namespace App\Services\Mailer;

use App\Models\Mail;
use App\Services\Mailer\MailerGatewayInterface;
use Exception;
use \SendGrid\Mail\Mail as SendGridMail;
use SendGrid;


class SendGridMailerGateway implements MailerGatewayInterface{


    private $sendgridService;
    private $emailMessage;

    public function __construct()
    {
        $api_key = getenv('SENDGRID_API_KEY');
        $this->sendgridService = new SendGrid($api_key);
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

        $this->prepareMail($mail);
        $mail->bounced();

        $response = $this->sendgridService->send($this->emailMessage);

        if($response->statusCode() > 202){
            $mail->failed();
            \Log::error($e->getMessage());
            \Log::error($e->getTraceAsString());
            throw new Exception($response->body());
        }

        $mail->delivered();

    }


}
