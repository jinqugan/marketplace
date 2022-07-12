<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $methods = [
            [
                'name' => 'debit_card',
                'status' => 1
            ],
            [
                'name' => 'credit_card',
                'status' => 1
            ]
        ];
        
        PaymentMethod::insert($methods);
    }
}
