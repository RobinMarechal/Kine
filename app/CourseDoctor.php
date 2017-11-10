<?php

namespace App\Pivot;

use Illuminate\Database\Eloquent\Model;

class CourseDoctor extends Model 
{

    protected $table = 'course_doctor';
    public $timestamps = false;
    protected $fillable = array('course_id', 'doctor_id');

}