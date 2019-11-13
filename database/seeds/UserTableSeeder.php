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
            'last_name' => 'Admin',
            'email' => 'admin@admin.com',
            'user_type' => 'Admin',
            'password' => bcrypt('123456789')
        ]);

        DB::table('users')->insert([
            'first_name' => 'test',
            'last_name' => 'test',
            'email' => 'test@test.com',
            'user_type' => 'Exhibitor',
            'password' => bcrypt('123456789')
        ]);

        DB::table('users')->insert([
            'first_name' => 'Bishoy',
            'last_name' => 'Fayz',
            'email' => 'bishoysouser@gmail.com',
            'user_type' => 'Innovator',
            'password' => bcrypt('123456789')
        ]);

        DB::table('users')->insert([
            'first_name' => 'user',
            'last_name' => 'user',
            'email' => 'userr@gmail.com',
            'user_type' => 'Company',
            'password' => bcrypt('123456789')
        ]);
    }
}
