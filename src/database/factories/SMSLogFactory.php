<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\SMSGateway\Ghasedak;
use App\SMSGateway\Kavenegar;
use Illuminate\Support\Arr;

class SMSLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $provider = Arr::random([
            Kavenegar::SMS_PROVIDER_NAME,
            Ghasedak::SMS_PROVIDER_NAME
        ]);

        return [
            'message' => $this->faker->word(),
            'mobile' =>  "0935901" . $this->faker->numberBetween(1000, 9999),
            'sms_provider' => $provider
        ];
    }
}
