<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Detail;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class DetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customerAmount = (int)$this->command->ask('How many customers you want?', 100);

        Detail::factory()->count($customerAmount)->create();

        Detail::all()->each(function($detailItem) {
            $customer = Customer::factory()->make();
            $detailItem->customer()->save($customer);
        });
    }
}
