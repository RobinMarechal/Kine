<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use function explode;
use Illuminate\Http\Request as BaseRequest;

class Request extends BaseRequest
{
	public $post = [];


	public function __construct (array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
	{
		parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

		$this->post = $_POST;
	}


	public function post ($key = null)
	{
		return isset($key) ? $this->post[ $key ] : $this->post;
	}


	// ?....&limit=..&offset=...
	public function applyLimitingParameters (&$query)
	{
		if ($this->has("limit")) {
			$query = $query->take($this->get("limit"));
		}

		if ($this->has("offset")) {
			$query = $query->skip($this->get("offset"));
		}
	}


	// ?....&orderby=..&order=...
	public function applyOrderingParameters (&$query)
	{
		if ($this->has("orderby")) {
			if ($this->has("order")) {
				$query = $query->orderBy($this->get("orderby"), $this->get("order"));
			}
			else {
				$query = $query->orderBy($this->get("orderby"));
			}
		}
	}


	// ?....&from=..&to=...
	public function applyTemporalParameters (&$query, $class)
	{
		$modelClassName = '\\' . $class;
		$temporalField = (new $modelClassName())->temporalField;

		if (isset($temporalField) && $temporalField != null) {
			$from = $this->has("from") ? Carbon::parse($this->get("from")) : null;
			$to = $this->has("to") ? Carbon::parse($this->get("to")) : null;

			if (isset($from) && isset($to)) {
				$query = $query->whereBetween($temporalField, [$from, $to]);
			}
			else if ($this->has("from")) {
				$query = $query->where($temporalField, '>=', $from);
			}
			else if ($this->has("to")) {
				$query = $query->where($temporalField, '<=', $to);
			}
		}
	}


	// ?....&with=rel1,rel2,rel3.rel3rel...
	public function applyRelationsParameters (&$query)
	{
		if ($this->has("with")) {
			$with = $this->get("with");
			if ($with == "all" || $with == '*') {
				$query->withAll();
			}
			else {
				$withArr = explode(",", $this->get('with'));
				$query->with($withArr);
			}
		}

		return $query;
	}


	public function applyFieldSelectingParameters (&$query)
	{
		if ($this->has('select')) {
			$fields = $this->get('select');
			$arr = explode(',', $fields);
			$query->select($arr);
		}
	}


	public function applyWhereParameter (&$query)
	{
		if ($this->has('where')) {
			$wheres = explode(';', $this->get('where'));
			foreach ($wheres as $where) {
				$where = explode(',', $where);
				if (isset($where[2])) {
					$query->where($where[0], $where[1], $where[2]);
				}
				else if (isset($where[1])) {
					$query->where($where[0], $where[1]);
				}
			}
		}
	}


	public function getPreparedQuery ($class)
	{
		$query = $class::query();

		$this->applyUrlParams($query, $class);

		return $query;
	}


	public function applyUrlParams (&$query, $class)
	{
		$this->applyRelationsParameters($query);
		$this->applyLimitingParameters($query);
		$this->applyOrderingParameters($query);
		$this->applyTemporalParameters($query, $class);
		$this->applyFieldSelectingParameters($query);
		$this->applyWhereParameter($query);
	}


	public function userWantsAll ()
	{
		return $this->has("all") && $this->get("all") == "true";
	}
}
