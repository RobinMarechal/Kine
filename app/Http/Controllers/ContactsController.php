<?php

namespace App\Http\Controllers;

use App\Content;
use App\User;
use function compact;

class ContactsController extends Controller
{
    public function whoAreWe()
    {
        $content = Content::getOrCreate('whoarewe');

        return view('whoarewe.index', compact('content'));
    }
}