<?php

namespace App\Http\Controllers;

use App\Event;
use App\News;
use Helpers\Template;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use const null;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


	/**
	 * Controller constructor.
	 */
	function __construct ()
	{
		$template_news = null;
		$template_events = null;
		$nbOfNotifications = null;

		if (Route::currentRouteName() != "home" && Route::currentRouteName() != "development") {

			$template_news = Template::getNews();
			$template_events = Template::getEvents();
			$nbOfNotifications = Template::getNbOfNotifications();
		}

		$footer_doctors = Template::getDoctors();
		$footer_other_contacts = Template::getOtherContacts();

		View::share(compact('template_news', 'template_events', 'nbOfNotifications', 'footer_doctors', 'footer_other_contacts'));
	}
}
