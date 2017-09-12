<?php

namespace App\Events;

use App\Article;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ArticlePublished
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

	public $article;
	public $tagIds;
	public $tagNames;


	/**
	 * Create a new event instance.
	 *
	 * @param Article $article
	 * @param array   $tagIds
	 * @param array   $tagNames
	 */
    public function __construct(Article $article, array $tagIds, array $tagNames)
    {
		$this->article = $article;
		$this->tagIds = $tagIds;
		$this->tagNames = $tagNames;
	}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
