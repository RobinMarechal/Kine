<?php

namespace App\Http\Controllers;

use App\Notification;
use App\Pivot\TagUser;
use App\User;
use Carbon\Carbon;
use function compact;
use Illuminate\Support\Facades\Auth;
use function implode;
use function response;

class UsersController extends Controller
{
    /**
     * Display all the user's notifications
     * @return Response1
     */
    public function showAllNotifications()
    {
        return $this->showNotifications(true);
    }


    /**
     * Display the user's unseed notifications
     *
     * @param bool $all
     *
     * @return \App\Http\Controllers\Response
     */
    public function showNotifications($all = false)
    {
        $user = Auth::user();

        $notifications = Notification::ofUser($user)
                                     ->unseen($all)
                                     ->fromNewerToOlder()
                                     ->paginate(10);

        foreach ($notifications as $n) {
            $n->seen_at = Carbon::now();
            $n->save();
        }

        return view('users.notifications', compact('notifications', 'all'));
    }


    public function updateTags($userId)
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

        $notification = "Vous possédez désormais les tags suivants : " . implode(', ', $tagNames) . ".";

        Notification::sendToUser($userId, $notification);

        return response()->json($result);
    }
}