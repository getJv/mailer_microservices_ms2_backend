<?php

namespace App\Services\Mailer;

use App\Models\Mail;
use App\Services\Mailer\AlternativeMailerGatewayInterface;
use Exception;
use \Mailjet\Resources;
use \Mailjet\Client;


class MailJetMailerGateway implements AlternativeMailerGatewayInterface{


    private $service;
    private $emailMessage;
    private $fromEmail;
    private $fromName;


    public function __construct()
    {
        $key = getenv('MAILJET_API_KEY');
        $secret = getenv('MAILJET_API_SECRET');
        $this->fromEmail = getenv('MAILJET_FROM_EMAIL');
        $this->fromName = getenv('MAILJET_FROM_NAME');
        $this->service = new Client($key,$secret,true,['version' => 'v3.1']);
    }

    private function prepareMail(Mail $mail){

        $this->emailMessage = [
            'Messages' => [
                [
                    'From' => [
                    'Email' => $this->fromEmail,
                    'Name' => $this->fromName
                    ],
                    'To' => [
                        [
                            'Email' => $mail->recipients,
                        ]
                    ],
                    'Subject' => $mail->title,
                    'HTMLPart' => $mail->body,
                    'CustomID' => "AppGettingStartedTest"
                ]
            ]
        ];
    }

    public function send(Mail $mail){

        $this->prepareMail($mail);
        $mail->bounced();
        $response = $this->service->post(Resources::$Email, ['body' => $this->emailMessage]);

        if(!$response->success()) {
            $mail->failed();
            \Log::error($e->getMessage());
            \Log::error($e->getTraceAsString());
            throw new Exception($response->getData());
        }

        $mail->delivered();


    }



}
