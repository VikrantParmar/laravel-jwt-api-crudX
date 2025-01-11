<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [];

        for ($i = 0; $i < 500; $i++) {
            $categories[] = [
                'name' => 'Category ' . Str::random(5),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('categories')->insert($categories);
    }
}
