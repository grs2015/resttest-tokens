<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::all()->each(function($customerItem) {
            $user = User::factory()->count(random_int(1, 5))->make();
            $customerItem->users()->saveMany($user);
        });


    }
}
