<?php

namespace App\Listeners;

use App\Events\ArticlePublished;
use App\Notification;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use function in_array;
use function is_array;

class SendNotification
{
	/**
	 * Create the event listener.
	 */
	public function __construct ()
	{
		//
	}


	/**
	 * Handle the event.
	 *
	 * @param  ArticlePublished $event
	 *
	 * @return void
	 */
	public function handle (ArticlePublished $event)
	{
		$article = $event->article;
		$tagIds = $event->tagIds;
		$tagNames = $event->tagNames;

		$users = User::distinct()
					 ->join('tag_user', 'users.id', '=', 'tag_user.user_id')
					 ->whereIn('tag_id', $tagIds)
					 ->whereLevel(0)
					 ->whereIsDoctor(false)
					 ->get(['name', 'users.id', 'tag_id', 'user_id']);

		$sentTo = [];

		foreach ($users as $u) {
			if(!in_array($u->id, $sentTo))
			{
				$sentTo[] = $u->id;
				Notification::sendToUser($u, "Nouvel article possédant les tags : " . join(', ', $tagNames) . '.', $article);
			}
		}
	}
}
