<?php

namespace App\Http\Controllers;

use App\Doctor;
use Illuminate\Http\Response;

class DoctorsController extends Controller
{
    public function post()
    {
        $id = $this->request->id;
        $doctor = Doctor::withTrashed()->find($id);

        if ($doctor) {
            $doctor->deleted_at = null;
            $doctor->save();
        }
        else {
            $doctor = Doctor::create($this->request->all());
        }

        $res = $doctor;

        if ($this->request->userWantsAll()) {
            $res = $this->all();
        }
        else if ($this->request->has("with")) {
            $with = $this->request->get('with');
            $with = explode(',', $with);

            foreach ($with as $w) {
                $res->load($w);
            }
        }

        return \response()->json($res, Response::HTTP_CREATED);
    }


    public function all()
    {
        $q = $this->getPreparedQuery(Doctor::class)->withoutMe()->get();

        return \response()->json($q);
    }
}
