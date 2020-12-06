<?php

namespace App\Providers;

use App\Services\Mailer\MailerGatewayInterface;
use App\Services\Mailer\AlternativeMailerGatewayInterface;
use App\Services\Mailer\MailJetMailerGateway;
use App\Services\Mailer\SendGridMailerGateway;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind( MailerGatewayInterface::class,function($app){
            return new SendGridMailerGateway();
        });

        $this->app->bind( AlternativeMailerGatewayInterface::class,function($app){
            return new MailJetMailerGateway();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
