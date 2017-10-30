<?php

namespace App\Pivot;

use Illuminate\Database\Eloquent\Model;

class CourseTag extends Model 
{

    protected $table = 'course_tag';
    public $timestamps = false;
    protected $fillable = array('course_id', 'tag_id');

}