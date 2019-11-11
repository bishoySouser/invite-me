<?php

use Illuminate\Database\Seeder;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        DB::table('events')->insert([
            'name' => 'event name',
            'event_start' => '09:00',
            'event_end' => '18:00',
            'edit' => 1,
        ]);
    }
}
