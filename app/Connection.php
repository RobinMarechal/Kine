<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    protected $table = 'connections';
    public $timestamps = true;
    protected $fillable = ['ip_address'];
    public $temporalField = 'created_at';
}
