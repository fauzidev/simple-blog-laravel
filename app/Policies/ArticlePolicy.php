<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    public function update(User $user, Article $article)
    {
        return $user->id === $article->user_id;
        // return response()->json([
        //     'success' => false,
        //     'message' => 'This is unauthorized',
        // ], 401);
    }
}
