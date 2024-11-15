<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
            DB::table('products')->insert(
                [
                'slug' => 'sach-giao-khoa',
                'image' => '',
                'name' => 'Sach Giao Khoa',
                'sku'     => 'SGK123',
                'price' => 30000,
                'sale' => 25000,
               'short_description' => 'Sach Giao Khoa',
                'long_description' => 'Sach Giao Khoa',
                'author' => 'Author',
                'publisher' => 'Publisher',
                'released' => 2023,
                'weight' => '1kg',
                'page' => 300,
                'best' => 1,
                'active' => 1,
                'order' => 1,
                'quantity' => 100,
    
            ]
            );
        
       
    }
}
