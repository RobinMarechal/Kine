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

		if (count($tagIds) == 0) {
			if ($article->wasRecentlyCreated) {
				$users = User::ofLevel(0)
							 ->get(['id']);
				$content = 'Un nouvel article publique vient d\'être publié : « ' . $article->title . ' ».';
			}
			else {
				$users = User::distinct()
							 ->leftJoin('notifications', 'user_id', '=', 'users.id')
							 ->ofLevel(0)
							 ->where('is_doctor', false)
							 ->whereNull('notifiable_id')
							 ->orWhere('notifiable_id', $article->id)
							 ->get(['users.id']);

				$content = 'Vous avez accès à un nouvel article : « ' . $article->title . ' ».';
			}
		}
		else {
			if ($article->wasRecentlyCreated) {
				$users = User::distinct()
							 ->join('tag_user', 'users.id', '=', 'tag_user.user_id')
							 ->whereIn('tag_id', $tagIds)
							 ->whereLevel(0)
							 ->whereIsDoctor(false)
							 ->get(['users.id']);


				$content = 'Un nouvel article a été publié : « ' . $article->title . ' ».';
			}
			else {
				$users = User::distinct()
							 ->join('tag_user', 'users.id', '=', 'tag_user.user_id')
							 ->leftJoin('notifications', 'users.id', '=', 'notifications.user_id')
							 ->whereIn('tag_id', $tagIds)
							 ->whereLevel(0)
							 ->whereIsDoctor(false)
							 ->whereNotIn('users.id', function ($query) use ($article) {
								 $query->select('user_id')
									   ->from('notifications')
									   ->where('notifiable_id', $article->id);
							 })
							 ->get(['users.id']);

				$content = 'Vous avez maintenant accès à un nouvel article : « ' . $article->title . ' ».';
			}
		}



		$notifications = [];
		foreach ($users as $u) {
			$array = [
				'user_id'         => $u->id,
				'content'         => $content,
				'link'            => '/articles/' . $article->id,
				'notifiable_id'   => $article->id,
				'notifiable_type' => 'Article',
			];

			$notifications[] = $array;
		}

		Notification::insert($notifications);
	}
}
