<?php

namespace App\Http\Controllers;

use App\Notification;
use App\Pivot\TagUser;
use App\User;
use function compact;
use Illuminate\Support\Facades\Auth;
use function response;

class UsersController extends Controller
{

	/**
	 * Display a listing of the resource.
	 * @return Response
	 */
	public function index ()
	{
	}


	/**
	 * Show the form for creating a new resource.
	 * @return Response
	 */
	public function create ()
	{
	}


	/**
	 * Store a newly created resource in storage.
	 * @return Response
	 */
	public function store ()
	{
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function show ($id)
	{
	}


	/**
	 * Display the user's unseed notifications
	 * @return Response
	 */
	public function showNotifications ($all = false)
	{
		$user = Auth::user();

		$notifications = Notification::ofUser($user)
									 ->unseen($all)
									 ->fromNewerToOlder()
									 ->paginate(1);

		return view('users.notifications', compact('notifications', 'all'));
	}


	/**
	 * Display all the user's notifications
	 * @return Response1
	 */
	public function showAllNotifications ()
	{
		return $this->showNotifications(true);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function edit ($id)
	{
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function update ($id)
	{
	}


	public function updateTags ($userId)
	{
		User::findOrFail($userId);

		TagUser::whereUserId($userId)
			   ->delete();

		$array = [];
		foreach ($this->request->tags as $tag) {
			$array[] = ['user_id' => $userId, 'tag_id' => $tag];
		}

		TagUser::insert($array);

		$pivots = TagUser::with('tag')
					  ->whereUserId($userId)
					  ->get();

		$tagNames = [];

		foreach ($pivots as $p) {
			$tagNames[] = $p->tag->name;
		}

		$result = ['user_id' => $userId, 'tags' => $tagNames];

		return response()->json($result);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function destroy ($id)
	{
	}

}



?>