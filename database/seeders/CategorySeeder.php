<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = collect([
            'Power Analyzer',
            'Frequency Analyzer',
            'Impedance Analyzer',
            'Power Source',
            'Insulation Tester',
            'Resistance Tester',
            'AC/DC Motor Tester',
            'Battery Tester',
            'Appliance Tester',
            'EMC Test Generator',
            'EMC Test Receiver'
        ]);

        $categories->each(function($categoryItem) {
            $category = Category::factory()->make();
            $category->title = $categoryItem;
            $category->slug = Str::slug(strtolower($categoryItem));
            $category->save();
        });
    }
}
