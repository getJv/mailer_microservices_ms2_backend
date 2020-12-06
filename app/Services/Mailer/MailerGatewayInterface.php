<?php

namespace App\Services\Mailer;

use App\Models\Mail;

interface MailerGatewayInterface{

    public function send(Mail $mail);


}
