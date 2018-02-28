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
        $u = User::create([
        	'email' => 'robin-marechal@hotmail.fr',
			'name' => 'Robin Marechal',
			'facebook_id' => '10210494984666394',
			'password' => bcrypt('adminlsem'),
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
