<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class About extends Model
{
	protected $table = 'abouts';

	use SoftDeletes;

	public $urlNamespace = 'abouts';
	protected $fillable = ['title', 'content', 'slug'];
	public $timestamps = false;


	/** @noinspection PhpHierarchyChecksInspection
	 * @param array $attributes
	 *
	 * @return \Illuminate\Database\Eloquent\Builder|Model
	 */
	public static function create (array $attributes = [])
	{
		$random = generateRandomNumberString(rand(5, 10));

		$attributes['slug'] = str_slug($attributes['title']) . '-' . $random;

		$model = static::query()
					   ->create($attributes);

		return $model;
	}
}
