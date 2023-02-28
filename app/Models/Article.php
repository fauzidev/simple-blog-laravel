<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'body'
    ];

    public function article_tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tags', 'article_id','tag_id')
                    ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function comments()
    {
        return $this->hasMany(ArticleComment::class);
    }
}
