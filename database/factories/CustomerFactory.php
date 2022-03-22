<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Detail;
use App\Models\Region;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $title = $this->faker->company(),
            'region_id' => Region::all()->random()->id,
            'branch_id' => Branch::all()->random()->id,
            'slug' => Str::slug(strtolower($title))
            // 'detail_id' => Detail::all()->random()->id
        ];
    }
}
