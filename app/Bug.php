<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bug extends Model
{
    const PENDING = 1;
    const SOLVED = 2;
    const ALL = 3;


    public $urlNamespace = 'bugs';
    public $timestamps = false;
    public $temporalField = 'created_at';

    protected $table = 'bugs';
    protected $dates = ['solved_at', 'created_at'];
    protected $fillable = ['solved_at', 'user_id', 'description', 'reporter_ip', 'summary'];


    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
