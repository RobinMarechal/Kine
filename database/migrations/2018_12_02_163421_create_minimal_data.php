<?php

use App\About;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMinimalData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        About::create([
            'title' => 'Erreurs 404',
            'slug' => 'erreurs-404',
        ]);

        About::create([
            'title' => 'La système de tags',
            'slug' => 'tags',
        ]);

        About::create([
            'title' => 'Signaler un bug',
            'slug' => 'signaler-un-bug',
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
