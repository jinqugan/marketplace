<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            /**
             * Account status
             */
            [
                'name' => 'pending',
                'lang_code' => 'status.account_pending',
                'type' => 'account',
                'access' => true,
                'description' => 'account valid and unverified. Account unverified able to login'
            ],
            [
                'name' => 'active',
                'lang_code' => 'status.account_active',
                'type' => 'account',
                'access' => true,
                'description' => 'account valid and verified. Account verified able to login'
            ],
            [
                'name' => 'inactive',
                'lang_code' => 'status.account_inactive',
                'type' => 'account',
                'access' => true,
                'description' => 'account valid but inactive for a period of time. Account inactive able to login'
            ],
            [
                'name' => 'disabled',
                'lang_code' => 'status.account_disabled',
                'type' => 'account',
                'access' => false,
                'description' => 'account invalid and disabled by admin. Account disabled unable to login'
            ],
            [
                'name' => 'suspended',
                'lang_code' => 'status.account_suspended',
                'type' => 'account',
                'access' => false,
                'description' => 'account invalid and suspended by admin/system. Account suspended unable to login'
            ],
            [
                'name' => 'deleted',
                'lang_code' => 'status.account_deleted',
                'type' => 'account',
                'access' => false,
                'description' => 'account invalid and not exist in our system. Account deleted unable to login'
            ],
            /**
             * Product status
             */
            [
                'name' => 'pending_publish',
                'lang_code' => 'status.product_pending_publish',
                'type' => 'product',
                'access' => false,
                'description' => null,
            ],
            [
                'name' => 'published',
                'lang_code' => 'status.product_published',
                'type' => 'product',
                'access' => false,
                'description' => null,
            ],
            [
                'name' => 'draft',
                'lang_code' => 'status.product_draft',
                'type' => 'product',
                'access' => false,
                'description' => null,
            ],
            [
                'name' => 'out_of_stock',
                'lang_code' => 'status.product_outofstock',
                'type' => 'product',
                'access' => false,
                'description' => null,
            ],
            [
                'name' => 'pending_payment',
                'lang_code' => 'status.product_pending_payment',
                'type' => 'product',
                'access' => false,
                'description' => null,
            ],
            [
                'name' => 'sold',
                'lang_code' => 'status.product_sold',
                'type' => 'product',
                'access' => false,
                'description' => null,
            ],
            /**
             * Payment status
             */
            [
                'name' => 'pending',
                'lang_code' => 'status.payment_pending',
                'type' => 'payment',
                'access' => false,
                'description' => null,
            ],
            [
                'name' => 'success',
                'lang_code' => 'status.payment_success',
                'type' => 'payment',
                'access' => false,
                'description' => null,
            ],
            [
                'name' => 'failed',
                'lang_code' => 'status.payment_failed',
                'type' => 'payment',
                'access' => false,
                'description' => null,
            ]
        ];

        Status::insert($statuses);
    }
}
