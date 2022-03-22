<?php

namespace Database\Seeders;

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
        if ($this->command->confirm('Do you want to refresh the database?')) {
            $this->command->call('migrate:refresh');
            $this->command->info('Database was refreshed');
        }

        $this->call([
            BranchSeeder::class,
            RegionSeeder::class,
            DetailSeeder::class,
            UserSeeder::class,
            OrderSeeder::class,
            CategorySeeder::class,
            ProducerSeeder::class,
            ProductSeeder::class,
            OrderItemSeeder::class
        ]);
    }
}
