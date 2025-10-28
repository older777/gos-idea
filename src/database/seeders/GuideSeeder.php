<?php

namespace Older777\Gosidea\database\seeders;

use Illuminate\Database\Seeder;
use Older777\GosIdea\Models\Guide;

class GuideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Guide::firstOrCreate([
            'name' => 'Пётр',
        ], [
            'name' => 'Пётр',
            'experience_years' => 0,
            'is_active' => true,
        ]);
        Guide::firstOrCreate([
            'name' => 'Иван',
        ], [
            'name' => 'Иван',
            'experience_years' => 2,
            'is_active' => true,
        ]);
        Guide::firstOrCreate([
            'name' => 'Дерсу Узала',
        ], [
            'name' => 'Дерсу Узала',
            'experience_years' => 35,
            'is_active' => true,
        ]);
    }
}
