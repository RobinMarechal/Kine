<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$this->call(DoctorsSeeder::class);
		$this->call(ContactsSeeder::class);
		$this->call(TestUsersSeeder::class);
    }
}
