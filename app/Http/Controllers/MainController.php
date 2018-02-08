<?php

namespace App\Http\Controllers;

use App\About;
use App\Connection;
use App\Content;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Laracasts\Flash\Flash;

class MainController extends Controller
{
	public function index ()
	{
		$userIp = $this->request->server("REMOTE_ADDR");

		$test = Connection::whereIpAddress($userIp)->first();
		if(!isset($test)) {
			Connection::create(['ip_address' => $userIp]);
		}

		$content = Content::getOrCreate('home');

		return view('home', compact('content'));
	}


	public function test ()
	{

	}


	public function dev ()
	{
		return view('development');
	}


	public function e404 ()
	{
		return view('errors.404');
	}

	public function about()
	{
		$abouts = About::orderBy('title', 'asc')->get();

		return view('others.about', compact('abouts'));
	}

	public function bug()
	{
		return view('others.bugs');
	}

	public function cgu()
	{
		$cgu = Content::getOrCreate('cgu');
		return view('others.cgu', compact('cgu'));
	}

	public function updateImage(){
        $isBanner = $this->request->isBanner;
        $file = $this->request->file('image');

        if(!$file->isValid()){
            Flash::error('Une erreur est survenue : le fichier est invalide.');
            return Redirect::back();
        }

        $path = $file->path();
        $ext = 'png';
        $filename = ($isBanner ? "banner" : "logo");
        $completeFilename = $filename . ".$ext";

        $storage = Storage::disk('public');

        if ($storage->exists("$filename.png")) {
        	if($storage->exists("$filename.png.bckp")){
        		$storage->delete("$filename.png.bckp");
        	}
        	$storage->move("$filename.png", "$filename.png.bckp");
        }

        $storage->putFileAs("", $file, "$filename.png");

        Flash::success("L'image a bien été modifiée.");
        return Redirect::back();
    }

    public function undoImage($type){
    	$filename = "$type.png";
    	$backupFilename = "$filename.bckp";
    	$tmpFilename = "$backupFilename.tmp";
    	$storage = Storage::disk('public');

    	if(!$storage->exists($backupFilename)){
    		if($type === "banner")
    			Flash::error("Il n'y a pas d'ancienne image de couverture à rétablir.");
    		else
    			Flasg::error("Il n'a pas d'ancien logo à rétablir.");

    		return Redirect::back();
    	}

    	$storage->move($filename, $tmpFilename); // banner.png, banner.png.bckp.tmp
    	$storage->move($backupFilename, $filename); // banner.png.bckp, banner.png
    	$storage->move($tmpFilename, $backupFilename); // banner.png.bckp.tmp, banner.png.bckp

		if($type === "banner")
			Flash::success("L'ancienne image de couverture a bien été rétablie.");
		else
    		Flash::success("L'ancien logo a bien été rétabli.");

    	return Redirect::back();
    }
}
