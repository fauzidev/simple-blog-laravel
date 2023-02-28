<?php

namespace App\Http\Controllers;

use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TagController extends Controller
{

    public function index()
    {
        $tags = Tag::orderBy('name')->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Tag berhasil ditampilkan',
            'data' => TagResource::collection($tags)
        ], 200);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:tags,name',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $tag = Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tag berhasil ditambahkan',
            'data' => new TagResource($tag)
        ], 200);

    }

    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $tag->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tag berhasil diupdate',
            'data' => new TagResource($tag)
        ], 200);
    }

    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);

        $tag->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tag berhasil didelete',
            'data' => new TagResource($tag)
        ], 200);
    }
}
