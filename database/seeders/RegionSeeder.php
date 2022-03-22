<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = collect([
            'Алтайский край',
            'Амурская область',
            'Архангельская область',
            'Астраханская область',
            'Белгородская область',
            'Брянская область',
            'Владимирская область',
            'Волгоградская область',
            'Вологодская область',
            'Воронежская область',
            'Москва',
            'Еврейская автономная область',
            'Забайкальский край',
            'Ивановская область',
            'Иркутская область',
            'Кабардино-Балкарская Республика'
        ]);

        $regions->each(function($regionItem) {
            $regionInstance = app(Region::class);
            $regionInstance->region = $regionItem;
            $regionInstance->region_short = (explode(' ', $regionItem))[0];
            $regionInstance->save();
        });
    }
}
