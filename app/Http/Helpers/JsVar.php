<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 06/09/2017
 * Time: 19:36
 */

namespace Helpers;


use Illuminate\Support\Facades\View;
use function json_encode;

class JsVar
{
	private $data;
	private $json;
	private $name;

	private static $vars = [];

	function __construct ($name, $data)
	{
		$this->name = $name;
		$this->data = $data;
	}


	public static function create ($name, $data)
	{
		$var = new JsVar($name, $data);
		$var->addToList();
		return $var;
	}


	public function addToList ()
	{
		$this->json = json_encode($this->data);
		JsVar::$vars[] = $this;
	}


	public static function sendAll ()
	{
		View::share(['js_vars' => self::$vars]);
	}


	public static function getVars ()
	{
		return self::$vars;
	}


	/**
	 * @return mixed
	 */
	public function getData ()
	{
		return $this->data;
	}


	/**
	 * @param mixed $data
	 *
	 * @return JsVar
	 */
	public function setData ($data)
	{
		$this->data = $data;

		return $this;
	}


	/**
	 * @return mixed
	 */
	public function getJson ()
	{
		return $this->json;
	}


	/**
	 * @param mixed $json
	 *
	 * @return JsVar
	 */
	public function setJson ($json)
	{
		$this->json = $json;

		return $this;
	}


	/**
	 * @return mixed
	 */
	public function getName ()
	{
		return $this->name;
	}


	/**
	 * @param mixed $name
	 *
	 * @return JsVar
	 */
	public function setName ($name)
	{
		$this->name = $name;

		return $this;
	}
}