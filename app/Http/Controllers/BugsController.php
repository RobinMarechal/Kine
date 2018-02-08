<?php

namespace App\Http\Controllers;

use App\Bug;
use Illuminate\Http\Response;

class BugsController extends Controller
{
    public function show($id)
    {
        $bug = Bug::with('user')->find($id);

        return view('admin.bugs.show', compact('bug'));
    }


    public function showPending()
    {
        $bugs = Bug::whereNull('solved_at')->orderBy('created_at')->paginate(20);
        $state = Bug::PENDING;

        return view('admin.bugs.index', compact('bugs', 'state'));
    }


    public function showSolved()
    {
        $bugs = Bug::whereNotNull('solved_at')->paginate(20);
        $state = Bug::SOLVED;

        return view('admin.bugs.index', compact('bugs', 'state'));
    }


    public function showAll()
    {
        $bugs = Bug::orderBy('created_at')->paginate(20);
        $state = Bug::ALL;

        return view('admin.bugs.index', compact('bugs', 'state'));
    }


    public function post()
    {
        $this->request['reporter_ip'] = $this->request->server("REMOTE_ADDR");

        return parent::post();
    }


    public function put($id)
    {
        $bug = Bug::find($id);
        $bug->solved_at = $this->request->solved_at;
        $bug->save();

        return \response()->json($bug, Response::HTTP_CREATED);
    }
}
