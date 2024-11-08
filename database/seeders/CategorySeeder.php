<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
            'name' => 'Electronics',
            'slug' => 'Electronics',
            'parent_id' => 0,
            'image' => 'https://example.com/electronics.jpg',
            ],
            [
            'name' => 'Sony',
            'slug' => 'Sony',
            'parent_id' => 0,
            'image' => 'https://example.com/electronics.jpg',
            ],

           
        ]);
    }
}
