<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Http\Resources\DetailArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ArticleController extends Controller
{

    public function index()
    {
        $article = Article::latest()->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Tag berhasil ditambahkan',
            'data' => ArticleResource::collection($article),
        ], 200);

    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:255',
            'tag' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $user = auth()->user();

        $article = $user->articles()->create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
        ]);

        $article->article_tags()->attach($request->tag);

        return response()->json([
            'success' => true,
            'message' => 'Article berhasil ditambahkan',
            'data' => new ArticleResource($article),
        ], 200);
    }

    public function show($article_slug)
    {
        $article = Article::with('comments')->where('slug', $article_slug)->firstOrFail();

        return response()->json([
            'success' => true,
            'message' => 'Detail Article Berhasil ditampilkan',
            'data' => new DetailArticleResource($article),
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:255',
            'tag' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $article = Article::findOrFail($id);

        $user = auth()->user();

        if ($article->user_id === $user->id) {

            $article->title = $request->title;
            $article->body = $request->body;
            $article->update();
    
            $article->article_tags()->sync($request->tag);
    
            return response()->json([
                'success' => true,
                'message' => 'Article berhasil diupdate',
                'data' => new ArticleResource($article),
            ], 200);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'This is not your article',
            ], 401);
        }
       
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        $article->article_tags()->detach();
        $article->delete();

        return response()->json([
            'success' => true,
            'message' => 'Article berhasil dihapus',
            'data' => new ArticleResource($article),
        ], 200);
    }

}
