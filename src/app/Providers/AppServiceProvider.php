<?php

namespace App\Providers;

use App\Exceptions\CredentialsException;
use Illuminate\Support\ServiceProvider;
use App\SMSGateway\Kavenegar;
use App\SMSGateway\Ghasedak;
use App\SMSGateway\SMSAdapter;
use InvalidArgumentException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SMSAdapter::class, function () {

            switch (env('SMS_PROVIDER')) {

                case Kavenegar::SMS_PROVIDER_NAME:
                    $sender = env('KAVENEGAR_SENDER');
                    $apiKey = env('KAVENEGAR_API_KEY');
                    if (empty($apiKey)) {
                        throw new CredentialsException('Apikey is not provided.');
                    }
                    return new Kavenegar($apiKey, $sender);
                    break;

                case Ghasedak::SMS_PROVIDER_NAME:
                    $sender = env('GHASEDAK_SENDER');
                    $apiKey =  env('GHASEDAK_API_KEY');
                    if (empty($apiKey)) {
                        throw new CredentialsException('Apikey is not provided.');
                    }
                    return new Ghasedak($apiKey, $sender);

                default:
                    throw new CredentialsException("SMS provider credentials is missing.");
                    break;
            }
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
