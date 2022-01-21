<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SMSLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => "admin",
            'email' => "test@example.com",
            'password' => Hash::make("123456")
        ]);

        SMSLog::factory(100)->create();
    }
}
