<?php

namespace App\Providers;

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
                case 'KAVENEGAR':
                    return new Kavenegar(env('KAVENEGAR_SENDER'), env('KAVENEGAR_API_KEY'));
                    break;

                case 'GHASEDAK':
                    return new Ghasedak(env('GHASEDAK_SENDER'), env('GHASEDAK_API_KEY'));

                default:
                    throw new InvalidArgumentException('SMS_PROVIDER is not set');
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
