<?php

use App\Contact;
use App\User;
use Illuminate\Database\Seeder;

class DoctorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pierre = User::create([
        	'email' => 'pierre.gabo@hotmail.fr',
			'name'=> 'Pierre Gabory',
			'level' => 1,
			'phone' => '0662119806',
			'starts_at' => '08:30:00',
			'ends_at' => '18:30:00',
			'is_doctor' => true,
		]);


		$steph = User::create([
			'email' => 'stephanie.jspaquoi@gmail.com',
			'name'=> 'Stéphanie Jspaquoi',
			'level' => 1,
			'phone' => '0776954532',
			'starts_at' => '09:00:00',
			'ends_at' => '19:00:00',
			'is_doctor' => true,
		]);


		$mich = User::create([
			'email' => 'michael-jorson@laposte.net',
			'name'=> 'Michael Jorson',
			'level' => 1,
			'phone' => '0662489506',
			'starts_at' => '08:00:00',
			'ends_at' => '17:30:00',
			'is_doctor' => true,
		]);


		Contact::create([
			'type' => 'PHONE',
			'value' => '0662119846',
			'description' => 'zertyui yvze ibzef',
			'user_id' => $pierre->id
		]);


		Contact::create([
			'type' => 'PHONE',
			'value' => '0268349502',
			'description' => '02 pierre',
			'user_id' => $pierre->id
		]);


		Contact::create([
			'type' => 'EMAIL',
			'value' => 'pierre.gabo@hotmail.fr',
			'description' => 'email pro pierre',
			'user_id' => $pierre->id
		]);


		Contact::create([
			'type' => 'LINK',
			'value' => 'https://www.facebook.com/groups/1695811207299368/',
			'description' => 'Page facebook',
			'user_id' => $pierre->id
		]);



		Contact::create([
			'type' => 'PHONE',
			'value' => '0765641485',
			'description' => '06 steph',
			'user_id' => $steph->id
		]);


		Contact::create([
			'type' => 'PHONE',
			'value' => '0285469515',
			'description' => '02 mich',
			'user_id' => $mich->id
		]);


		Contact::create([
			'type' => 'EMAIL',
			'value' => 'mich-michou@laposte.net',
			'description' => 'mail mich',
			'user_id' => $mich->id
		]);




		// Others


		Contact::create([
			'type' => 'PHONE',
			'value' => '0264970532',
			'description' => 'Tel cabinet',
		]);

		Contact::create([
			'type' => 'EMAIL',
			'value' => 'cabinet-kine@gmail.com',
			'description' => 'Email cabinet',
		]);

		Contact::create([
			'type' => 'LINK',
			'value' => 'https://www.facebook.com/groups/304676906577725/',
			'description' => 'Page fb cabinet',
		]);
    }
}
