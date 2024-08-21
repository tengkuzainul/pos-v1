<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mendapatkan UUID kategori dari database
        $categories = Category::pluck('uuid', 'name')->toArray();

        // Data produk
        $products = [
            ['name' => 'Es Kopi Gula Aren', 'price' => 18000, 'stock' => 100, 'category' => 'Signature'],
            ['name' => 'Es Kopi Pandan', 'price' => 20000, 'stock' => 100, 'category' => 'Signature'],
            ['name' => 'Caramel Macciato', 'price' => 20000, 'stock' => 100, 'category' => 'Latte'],
            ['name' => 'Caramel Latte', 'price' => 22000, 'stock' => 100, 'category' => 'Latte'],
            ['name' => 'Vanilla Latte', 'price' => 22000, 'stock' => 100, 'category' => 'Latte'],
            ['name' => 'Hazelnut Latte', 'price' => 18000, 'stock' => 100, 'category' => 'Latte'],
            ['name' => 'Coffee Latte', 'price' => 18000, 'stock' => 100, 'category' => 'Latte'],
            ['name' => 'Esporesso', 'price' => 18000, 'stock' => 100, 'category' => 'Coffee'],
            ['name' => 'Americano', 'price' => 18000, 'stock' => 100, 'category' => 'Coffee'],
            ['name' => 'Long Black', 'price' => 14000, 'stock' => 100, 'category' => 'Coffee'],
            ['name' => 'Sanger', 'price' => 16000, 'stock' => 100, 'category' => 'Coffee'],
            ['name' => 'Cappucino', 'price' => 18000, 'stock' => 100, 'category' => 'Coffee'],
            ['name' => 'Mocachino', 'price' => 18000, 'stock' => 100, 'category' => 'Coffee'],
            ['name' => 'Vietnam Drip', 'price' => 20000, 'stock' => 100, 'category' => 'Manual Brew'],
            ['name' => 'V60', 'price' => 20000, 'stock' => 100, 'category' => 'Manual Brew'],
            ['name' => 'Japanese', 'price' => 16000, 'stock' => 100, 'category' => 'Manual Brew'],
            ['name' => 'Coklat', 'price' => 16000, 'stock' => 100, 'category' => 'Chocolate'],
            ['name' => 'Strawberry', 'price' => 16000, 'stock' => 100, 'category' => 'Chocolate'],
            ['name' => 'Blueberry', 'price' => 16000, 'stock' => 100, 'category' => 'Chocolate'],
            ['name' => 'Berry Sweet', 'price' => 20000, 'stock' => 100, 'category' => 'Chocolate'],
            ['name' => 'Strawberry Fresh', 'price' => 22000, 'stock' => 100, 'category' => 'Chocolate'],
            ['name' => 'Lychee', 'price' => 15000, 'stock' => 100, 'category' => 'Non Coffee'],
            ['name' => 'Orange', 'price' => 15000, 'stock' => 100, 'category' => 'Non Coffee'],
            ['name' => 'Coklat Classic', 'price' => 15000, 'stock' => 100, 'category' => 'Chocolate'],
            ['name' => 'Coklat Caramel', 'price' => 15000, 'stock' => 100, 'category' => 'Chocolate'],
            ['name' => 'Coklat Hazelnut', 'price' => 15000, 'stock' => 100, 'category' => 'Chocolate'],
            ['name' => 'Red Velvet', 'price' => 20000, 'stock' => 100, 'category' => 'Chocolate'],
            ['name' => 'Taro', 'price' => 20000, 'stock' => 100, 'category' => 'Chocolate'],
            ['name' => 'Matcha', 'price' => 18000, 'stock' => 100, 'category' => 'Chocolate'],
            ['name' => 'Tea', 'price' => 18000, 'stock' => 100, 'category' => 'Non Coffee'],
            ['name' => 'Lemon Tea', 'price' => 18000, 'stock' => 100, 'category' => 'Non Coffee'],
            ['name' => 'Lychee Tea', 'price' => 18000, 'stock' => 100, 'category' => 'Non Coffee'],
            ['name' => 'Thai Tea', 'price' => 18000, 'stock' => 100, 'category' => 'Non Coffee'],
            ['name' => 'Peach Tea', 'price' => 18000, 'stock' => 100, 'category' => 'Non Coffee'],
            ['name' => 'Mie Goreng', 'price' => 20000, 'stock' => 100, 'category' => 'Noodle'],
            ['name' => 'Mie Rebus', 'price' => 20000, 'stock' => 100, 'category' => 'Noodle'],
            ['name' => 'Nasi Goreng Kampung', 'price' => 22000, 'stock' => 100, 'category' => 'Rice'],
            ['name' => 'Nasi Goreng Ayam', 'price' => 22000, 'stock' => 100, 'category' => 'Rice'],
            ['name' => 'Chicken Black Pepper', 'price' => 18000, 'stock' => 100, 'category' => 'Snack'],
            ['name' => 'Nugget', 'price' => 18000, 'stock' => 100, 'category' => 'Snack'],
            ['name' => 'Sosis', 'price' => 18000, 'stock' => 100, 'category' => 'Snack'],
            ['name' => 'Burger', 'price' => 20000, 'stock' => 100, 'category' => 'Snack'],
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'price' => $product['price'],
                'stock' => $product['stock'],
                'category_id' => $categories[$product['category']],
            ]);
        }
    }
}
