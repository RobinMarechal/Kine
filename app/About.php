<?php

namespace App;

use function array_key_exists;
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
		$attributes['slug'] = str_slug($attributes['title']);

		return static::query()->create($attributes);
	}


	public function update (array $attributes = [], array $options = [])
	{
		$attributes['slug'] = isset($attributes['title']) ? str_slug($attributes['title']) : $attributes['slug'];

		return parent::update($attributes, $options);
	}


}
