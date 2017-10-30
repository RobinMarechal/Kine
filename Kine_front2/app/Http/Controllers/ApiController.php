<?php

namespace App\Http\Controllers;

use function camel_case;
use function class_exists;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\Auth;
use function strtoupper;
use function substr;
use Symfony\Component\Debug\Exception\ClassNotFoundException;

class ApiController extends Controller
{
	public function user ()
	{
		return Auth::user();
	}


	public function dispatch ($resource, $id = null, $relation = null, $relatedId = null)
	{
		if ($this->request->path() == 'api/auth/user') {
			return $this->user();
		}

		try {

			$controllerClassName = "App\\Http\\Controllers\\" . strtoupper($resource[0]) . camel_case(substr($resource, 1)) . "Controller";

			if (!class_exists($controllerClassName)) {
				throw new ClassNotFoundException("Controller '$controllerClassName' doesn't exist.", new ErrorException());
			}

			$controller = new $controllerClassName($this->request);

			if (!isset($id)) {
				if ($this->request->isMethod("get")) {
					return $controller->all();
				}
				else if ($this->request->isMethod("post")) {
					return $controller->post();
				}
				else {
					goto EXCEPTION;
				}
			}


			if (!isset($relation)) // findById
			{
				if ($this->request->isMethod("get")) {
					return $controller->getById($id);
				}
				else if ($this->request->isMethod("put")) {
					return $controller->put($id);
				}
				else if ($this->request->isMethod("delete")) {
					return $controller->delete($id);
				}
				else {
					goto EXCEPTION;
				}
			}
			else {
				$function = camel_case("get_" . $relation);

				return $controller->$function($id, $relatedId);
			}
		} catch (Exception $e) {
			throw $e;
			throw new Exception("The given URL is not valid. It should look like one of these:
			\n - '.../api/[resource]/'
			\n - '.../api/[resource]/[id]/'
			\n - '.../api/[resource]/[id]/[relation]/'
			\n - '.../api/[resource]/[id]/[relation]/[relatedId]' \n 
			With: \n
			 - [resource] the wanted data in plural form (users, articles, news...) \n
			 - [id] the id of the wanted resource \n
			 - [relations] an existing relation of the wanted resource (e.g /users/1/courses; /articles/3/author) \n
			 - [relatedId] the id of the related resource (e.g /users/1/courses/2; /articles/2/medias/7)");
		}

		EXCEPTION:
		throw new Exception("The requested action is invalid. (" . $this->request->url() . " with method " . $this->request->method() . ")");
	}
}
