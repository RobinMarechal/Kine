<?php

namespace App\Pivot;

use Illuminate\Database\Eloquent\Model;

class TagUser extends Model 
{

    protected $table = 'tag_user';
    public $timestamps = false;
    protected $fillable = array('created_at', 'updated_at', 'user_id', 'tag_id');

}