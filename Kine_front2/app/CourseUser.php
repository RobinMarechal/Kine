<?php

namespace App\Pivot;

use Illuminate\Database\Eloquent\Model;

class CourseUser extends Model 
{

    protected $table = 'course_user';
    public $timestamps = false;
    protected $fillable = array('course_id', 'user_id');

}