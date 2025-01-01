<?php
/**
 * Created by.
 * User: VP
 * Date: 21/12/2024
 * Time: 03:35 PM
 */


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fetch the admin role ID
        $adminRoleId = DB::table('roles')->where('role', 'Admin')->first()->id;
        $userRoleId = DB::table('roles')->where('role', 'User')->first()->id;

        // Insert a dummy admin user
        DB::table('users')->insert([
            'unique_id' => 'VXC001',
            'first_name' => 'Vikrant',
            'last_name' => 'Parmar',
            'email' => 'vikrant-admin@example.com',
            'password' => Hash::make('123456789'),
            'role_id' => $adminRoleId,
            'status' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert a dummy user
        DB::table('users')->insert([
            'unique_id' => 'VXC002',
            'first_name' => 'Vicky',
            'last_name' => 'Dev',
            'email' => 'vikrant-user@example.com',
            'password' => Hash::make('123456789'),
            'role_id' => $userRoleId ,
            'status' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
