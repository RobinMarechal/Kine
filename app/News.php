<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * @property int            $id
 * @property \Carbon\Carbon $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property mixed          $medias
 */
class News extends Model
{

    public $timestamps = true;

    public $urlNamespace = 'news';

    public $temporalField = 'published_at';

    use SoftDeletes;

    protected $table = 'news';

    protected $dates = ['deleted_at', 'published_at'];

    protected $fillable = ['created_at', 'updated_at', 'doctor_id', 'title', 'content', 'published_at', 'views'];


    public function author()
    {
        return $this->doctor();
    }


    public function doctor()
    {
        return $this->belongsTo('App\Doctor')->withTrashed();
    }


    public function medias()
    {
        return $this->morphMany('App\Media', 'mediaable');
    }


    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', DB::raw('CURRENT_TIMESTAMP'));
    }


    public function scopeNotPublished($query)
    {
        $now = Carbon::now()->format("Y-m-d H:i:s");

        return $query->where('published_at', '>', DB::raw('CURRENT_TIMESTAMP'));
    }


    public function scopeFromNewerToOlder($query)
    {
        return $query->orderBy('published_at', 'DESC');
    }


    public function scopeFromOlderToNewer($query)
    {
        return $query->orderBy('published_at', 'ASC');
    }
}