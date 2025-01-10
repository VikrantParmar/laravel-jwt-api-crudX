<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            \Database\Seeders\RolesTableSeeder::class,
            \Database\Seeders\UsersTableSeeder::class,
            \Database\Seeders\CategoryTableSeeder::class
        ]);
    }
}
