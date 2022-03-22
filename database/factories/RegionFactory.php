<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RegionFactory extends Factory
{
    protected $regions = [
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
    ];

    protected $regionCollection;

    public function __construct()
    {
        $this->regionCollection = collect($this->regions);
    }
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'region' => $this->regionCollection->random(),
        ];
    }
}
