<?php

use App\Contact;
use App\Doctor;
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
			'is_doctor' => 1
		]);

        Doctor::create([
			'id' => $pierre->id,
			'phone' => '0662119806',
			'starts_at' => '08:30:00',
			'ends_at' => '18:30:00',
			'name'=> 'Pierre Gabory',
		]);

		$steph = User::create([
			'email' => 'stephanie.jspaquoi@gmail.com',
			'name'=> 'Stéphanie Jspaquoi',
			'is_doctor' => 1
		]);

		Doctor::create([
			'id' => $steph->id,
			'phone' => '0776954532',
			'starts_at' => '09:00:00',
			'ends_at' => '19:00:00',
			'name'=> 'Stéphanie Jspaquoi',
		]);


		$mich = User::create([
			'email' => 'michael-jorson@laposte.net',
			'name'=> 'Michael Jorson',
			'is_doctor' => 1
		]);

		Doctor::create([
			'id' => $mich->id,
			'phone' => '0662489506',
			'starts_at' => '08:00:00',
			'ends_at' => '17:30:00',
			'name'=> 'Michael Jorson',
		]);
		// Contacts

		Contact::create([
			'type' => 'PHONE',
			'value' => '0662119846',
			'description' => 'zertyui yvze ibzef',
			'doctor_id' => $pierre->id
		]);


		Contact::create([
			'type' => 'PHONE',
			'value' => '0268349502',
			'description' => '02 pierre',
			'doctor_id' => $pierre->id
		]);


		Contact::create([
			'type' => 'EMAIL',
			'value' => 'pierre.gabo@hotmail.fr',
			'description' => 'email pro pierre',
			'doctor_id' => $pierre->id
		]);


		Contact::create([
			'type' => 'LINK',
			'value' => 'https://www.facebook.com/groups/1695811207299368/',
			'description' => 'Page facebook',
			'doctor_id' => $pierre->id
		]);



		Contact::create([
			'type' => 'PHONE',
			'value' => '0765641485',
			'description' => '06 steph',
			'doctor_id' => $steph->id
		]);


		Contact::create([
			'type' => 'PHONE',
			'value' => '0285469515',
			'description' => '02 mich',
			'doctor_id' => $mich->id
		]);


		Contact::create([
			'type' => 'EMAIL',
			'value' => 'mich-michou@laposte.net',
			'description' => 'mail mich',
			'doctor_id' => $mich->id
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
