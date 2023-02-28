<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleCommentResource;
use App\Models\Article;
use App\Models\ArticleComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleCommentController extends Controller
{
    
    public function store(Request $request, $article_slug)
    {
        $validator = Validator::make($request->all(), [
            'body' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $user = auth()->user();

        $article = Article::where('slug', $article_slug)->firstOrFail();

        $comments = $user->articleComments()->create([
            'article_id' => $article->id,
            'body' => $request->body
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Komentar Berhasil ditampilkan',
            'data' => new ArticleCommentResource($comments),
        ], 200);
    }

    public function update(Request $request, $article_slug, $id)
    {
        $validator = Validator::make($request->all(), [
            'body' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $user = auth()->user();

        $article = Article::where('slug', $article_slug)->firstOrFail();

        $comments = $article->comments()->findOrFail($id);

        if ($article->user_id === $user->id) {
            $comments->body = $request->body;
            $comments->update();
            
            return response()->json([
                'success' => true,
                'message' => 'Komentar Berhasil Diupdate',
                'data' => new ArticleCommentResource($comments),
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'This is not your article',
            ], 401);
        }
    }
}
