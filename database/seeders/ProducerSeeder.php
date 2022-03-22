<?php

namespace Database\Seeders;

use App\Models\Producer;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ProducerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $producers = collect([
            'N4L Ltd',
            'Schloder GmbH',
            'GossenMetrawatt GmbH',
            'ET Systems GmbH',
            'ETL Pruftechnik GmbH'
        ]);

        $suffixes = ['ltd', 'gmbh'];

        $producers->each(function($producerItem) use ($suffixes) {
            $producer = Producer::factory()->make();
            $producer->title = $producerItem;
            $producer->slug = Str::slug(trim(Str::remove($suffixes, strtolower($producerItem))));
            $producer->save();
        });
    }
}
