<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Services\UserService;

class UserSeeder extends Seeder
{
    private $userService;

    /**
     * Create a new controller instance.
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = $this->userService->accountStatus(['keyBy' => 'name']);
        
        User::factory()->create([
            'username' => 'seller01',
            'name' => 'Test Seller01',
            'email' => 'seller01@marketplace.com',
            'status_id' => $statuses['active']['id']
        ]);
    }
}
