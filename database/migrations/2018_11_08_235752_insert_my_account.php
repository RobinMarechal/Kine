<?php

use App\Doctor;
use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertMyAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	$adm = User::create([
    		'email' => 'lsem@dmin',
			'name' => 'Admin',
			'is_doctor' => 1,
		]);

    	Doctor::create([
			'id' => $adm->id,
			'name' => $adm->name,
            'phone' => 'HIDE'
		]);

        $u = User::create([
        	'email' => 'robin-marechal@hotmail.fr',
			'name' => 'Robin Marechal',
			'facebook_id' => '10210494984666394',
			'is_doctor' => 1
		]);

        Doctor::create([
			'id' => $u->id,
			'phone' => '0662119806',
			'name' => 'Robin Marechal',
            'phone' => 'HIDE'
		]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
