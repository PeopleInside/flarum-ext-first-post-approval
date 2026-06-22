<?php

namespace PeopleInside\FirstPostApproval\Listeners;

use Flarum\Approval\Event\PostWasApproved; // ← CORRETTO: era Flarum\Post\Event\PostWasApproved
use Illuminate\Support\Facades\DB;
use PeopleInside\FirstPostApproval\Models\UserFirstPostApproval;

class CountPostApprovals
{
    public function handle(PostWasApproved $event)
    {
        $user = $event->post->user;

        if (!$user) {
            return;
        }

        if ($event->post->hidden_at) {
            return;
        }

        $isDiscussion = $event->post->number == 1;

        // Utilizzo di upsert per garantire atomicità ed evitare race conditions
        UserFirstPostApproval::upsert(
            [
                [
                    'user_id' => $user->id,
                    'first_discussion_approval_count' => $isDiscussion ? 1 : 0,
                    'first_post_approval_count' => !$isDiscussion ? 1 : 0,
                ]
            ],
            ['user_id'],
            [
                'first_discussion_approval_count' => DB::raw('first_discussion_approval_count + ' . ($isDiscussion ? 1 : 0)),
                'first_post_approval_count' => DB::raw('first_post_approval_count + ' . (!$isDiscussion ? 1 : 0)),
            ]
        );
    }
}
