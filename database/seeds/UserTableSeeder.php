<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Admin',
            'email' => 'admin@admin.com',
            'user_type' => 'Buyer',
            'password' => bcrypt('123456789')
        ]);

        DB::table('users')->insert([
            'first_name' => 'test',
            'email' => 'test@test.com',
            'user_type' => 'Buyer',
            'password' => bcrypt('123456789')
        ]);

        DB::table('users')->insert([
            'first_name' => 'Bishoy',
            'email' => 'bishoysouser@gmail.com',
            'user_type' => 'Exhibitors',
            'password' => bcrypt('123456789')
        ]);
    }
}
