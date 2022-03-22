<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branches = collect([
            'Электроэнергетика',
            'Топливная промышленность',
            'Чёрная металлургия',
            'Цветная металлургия',
            'Химическая промышленность',
            'Нефтехимическая промышленность',
            'Машиностроение',
            'Деревообрабатывающая промышленность',
            'Лёгкая промышленность',
            'Пищевая промышленность',
            'Медицинская промышленность',
            'Полиграфическая промышленность'
        ]);

        $branches->each(function($branchItem) {
            $branchInstance = new Branch();
            $branchInstance->branch = $branchItem;
            $branchInstance->branch_short = (explode(' ', $branchItem))[0];
            $branchInstance->save();
        });
    }
}
