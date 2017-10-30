<?php

namespace App\Pivot;

use Illuminate\Database\Eloquent\Model;

class ArticleTag extends Model 
{

    protected $table = 'article_tag';
    public $timestamps = false;
    protected $fillable = array('created_at', 'updated_at', 'article_id');

}