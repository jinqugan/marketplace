<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        
        if ($this->command->confirm('Do you want to truncate all table ?', true)) {
            $this->command->call('migrate:fresh');
        } else {
            $this->command->call('migrate');
        }

        $this->call(StatusSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PaymentMethodSeeder::class);
    }
}
