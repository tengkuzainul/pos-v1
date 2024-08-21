<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categries = [
            'Signature',
            'Latte',
            'Coffee',
            'Manual Brew',
            'Ice Cream',
            'Mocktail',
            'Chocolate',
            'Non Coffee',
            'Coffee Mocktail',
            'Creamy Mocktail',
            'Addtional',
            'Noodle',
            'Rice',
            'Snack',
        ];

        foreach ($categries as $category) {
            Category::create(['name' => $category]);
        }
    }
}
