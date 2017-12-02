<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DoctorsController extends Controller
{

	public function all ()
	{
		$q = $this->getPreparedQuery(Doctor::class)->withoutMe()->get();
		return \response()->json($q);
	}
}
