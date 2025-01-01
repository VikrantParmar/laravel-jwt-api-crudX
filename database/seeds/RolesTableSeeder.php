<?php
/**
 * Created by.
 * User: VP
 * Date: 21/12/2024
 * Time: 03:34 PM
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['role' => 'Admin', 'description' => 'Administrator role', 'created_at' => now(), 'updated_at' => now()],
            ['role' => 'User', 'description' => 'General user role', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
