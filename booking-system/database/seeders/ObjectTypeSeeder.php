<?php

namespace Database\Seeders;

use App\Models\ObjectType;
use Illuminate\Database\Seeder;

class ObjectTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'Спа',
            'Селски туризъм',
            'Хижа',
            'Вила',
            'Апартамент',
            'Къща за гости'
        ];

        foreach ($types as $type) {
            ObjectType::create(['name' => $type]);
        }
    }
}