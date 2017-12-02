<?php
namespace App\Http\Controllers\Admin;


use App\BugReport;
use App\Contact;
use App\Doctor;
use App\Http\Controllers\Controller;
use App\User;
use function array_merge;
use function compact;
use PhpParser\Comment\Doc;

class AdminsController extends Controller
{

	public function users ()
	{
		$users = User::with('courses', 'tags')
					 ->orderByName()
					 ->whereIsDoctor(0)
					 ->get();

		$doctors = Doctor::with('courses', 'articles', 'news', 'user')
						 ->where('id', '>', 1)
						 ->orderByName()
						 ->get();

		return view('admin.users', compact('users', 'doctors'));
	}


	public function contacts ()
	{
		$doctors = Doctor::orderByName()
						 ->where('id', '>', 1)
						 ->with('contacts')
						 ->get();
		$contacts = Contact::orderBy('type')
						   ->whereNull('doctor_id')
						   ->get();

		return view('admin.contacts', compact('doctors', 'contacts'));
	}


	public function showUser ($id)
	{
		$doctor = Doctor::with('contacts',
			'courses.tags',
			'courses.users',
			'articles.tags',
			'news')
						->findOrFail($id);

		return view('admin.user', compact('doctor'));
	}


	/**
	 * Display a listing of the resource.
	 * @return Response
	 */
	public function index ()
	{
		return view('admin.index');
	}


	public function showPendingBugReports()
	{
		$reports = BugReport::whereNull('solved_at')->paginate(20);
		$code = BugReport::PENDING;

		return view('admin.bugs', compact('reports', 'code'));
	}


	public function showSolvedBugReports()
	{
		$reports = BugReport::whereNotNull('solved_at')->paginate(20);
		$code = BugReport::SOLVED;

		return view('admin.bugs', compact('reports', 'code'));
	}

	public function showAllBugReports()
	{
		$reports = BugReport::orderBy('created_at')->paginate(20);
		$code = BugReport::ALL;

		return view('admin.bugs', compact('reports', 'code'));
	}

}