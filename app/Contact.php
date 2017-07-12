<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model 
{

    protected $table = 'contacts';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('created_at', 'updated_at', 'type', 'value', 'description', 'user_id');

    public function doctor()
    {
        return $this->belongsTo('App\User');
    }

}