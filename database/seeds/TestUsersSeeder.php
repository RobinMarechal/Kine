<?php

use App\User;
use Illuminate\Database\Seeder;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		User::create([
			'email' => 'john@doe',
			'name' => 'John Doe',
			'password' => bcrypt('johndoe')
		]);


		User::create([
			'email' => 'jane@doe',
			'name' => 'Jane Doe',
			'password' => bcrypt('janedoe')
		]);
    }
}
