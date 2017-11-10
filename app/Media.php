<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{

    protected $table = 'medias';
    public $timestamps = true;
	public $urlNamespace = 'galerie';

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['created_at', 'updated_at', 'type', 'path', 'post_type', 'post_id', 'description', 'title', 'doctor_id', 'views'];
	public $temporalField = 'created_at';


    public function doctor ()
    {
        return $this->belongsTo('App\Doctor');
    }


    public function author ()
    {
        return $this->belongsTo('App\Doctor');
    }


    public function posts ()
    {
        return $this->morphTo();
    }


	public function mediaable ()
	{
		return $this->morphTo();
	}
}