<?php

use Illuminate\Database\Seeder;

class UserTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_type')->insert([
            'type' => 'Buyer'
        ]);
        DB::table('user_type')->insert([
            'type' => 'Exhibitor'
        ]);
    }
}
