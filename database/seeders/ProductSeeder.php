<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Beras Pandan Wangi 5kg',
                'description' => 'Beras putih kualitas premium, pulen dan harum.',
                'price' => 75000,
                'stock' => 50,
                'category' => 'Sembako',
                'image' => null,
            ],
            [
                'name' => 'Minyak Goreng Filma 2 Liter',
                'description' => 'Minyak goreng kelapa sawit dalam kemasan pouch.',
                'price' => 38000,
                'stock' => 100,
                'category' => 'Sembako',
                'image' => null,
            ],
            [
                'name' => 'Gula Pasir Gulaku 1kg',
                'description' => 'Gula pasir putih kemasan premium.',
                'price' => 18500,
                'stock' => 80,
                'category' => 'Sembako',
                'image' => null,
            ],
            [
                'name' => 'Tepung Terigu Segitiga Biru 1kg',
                'description' => 'Tepung terigu serbaguna untuk aneka kue dan makanan.',
                'price' => 12000,
                'stock' => 60,
                'category' => 'Sembako',
                'image' => null,
            ],
            [
                'name' => 'Indomie Goreng (Dus)',
                'description' => 'Mie instan goreng paling populer. 1 Dus isi 40 bungkus.',
                'price' => 115000,
                'stock' => 20,
                'category' => 'Makanan Ringan',
                'image' => null,
            ],
            [
                'name' => 'Kopi Kapal Api Special 165g',
                'description' => 'Kopi bubuk murni dengan aroma khas.',
                'price' => 14500,
                'stock' => 100,
                'category' => 'Minuman',
                'image' => null,
            ],
            [
                'name' => 'Teh Sariwangi Isi 25',
                'description' => 'Teh celup asli indonesia.',
                'price' => 6500,
                'stock' => 150,
                'category' => 'Minuman',
                'image' => null,
            ],
            [
                'name' => 'Sabun Mandi Lifebuoy Cair 450ml',
                'description' => 'Sabun cair refill perlindungan kuman.',
                'price' => 22000,
                'stock' => 40,
                'category' => 'Perlengkapan Mandi',
                'image' => null,
            ],
            [
                'name' => 'Sunlight Jeruk Nipis 755ml',
                'description' => 'Cairan pencuci piring ekstrak jeruk nipis.',
                'price' => 18000,
                'stock' => 50,
                'category' => 'Lainnya',
                'image' => null,
            ],
            [
                'name' => 'Telur Ayam Negeri 1kg',
                'description' => 'Telur ayam segar per kilogram (isi sekitar 16-17 butir).',
                'price' => 28000,
                'stock' => 30,
                'category' => 'Sembako',
                'image' => null,
            ],
            [
                'name' => 'Susu Bear Brand 189ml',
                'description' => 'Susu steril murni siap minum.',
                'price' => 10500,
                'stock' => 120,
                'category' => 'Minuman',
                'image' => null,
            ],
            [
                'name' => 'Kecap Manis Bango 520ml',
                'description' => 'Kecap manis dari kedelai hitam pilihan.',
                'price' => 25000,
                'stock' => 60,
                'category' => 'Sembako',
                'image' => null,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
