<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Post -> post
class Post extends Model
{
    use HasFactory;

    // マスアサイメント（一括でデータを挿入する）をするために、値をどのカラムに挿入するかちゃんと設定する
    protected $fillable = [
        'title',
        'body',
    ];

    // リレーション設定  postsテーブルとcommentsテーブルをかんたんに操作できるようにする   （$post->comment 投稿に紐付いたコメントを取得できる）
    public function comments()
    {
        // 特定のpostに対してcommentは複数あるため hasMany    classキーワード：クラスの名前が文字列で渡される
        return $this->hasMany(Comment::class);
    }

    // リレーション設定 （postsテーブルから → post_imagesテーブルへの1体多リレーション）
    public function postImage()
    {
        return $this->hasMany(PostImage::class);
    }

    // リレーション設定 （postsテーブルから → bookmarksテーブルへの1対1リレーション）
    public function bookmarks()
    {
        // return $this->belongsToMany(Bookmark::class, 'bookmark');
        // return $this->belongsToMany(Bookmark::class);
        return $this->hasOne(Bookmark::class);
    }

    // 投稿を渡すとその投稿がブックマーク済みかどうかを返す
    public function isBookmarkedBy(Post $post)
    {
        // post.idとbookmarks.post_idが紐付いている場合、紐付いているレコードの個数を返す(bool型にキャストして返す)
        return $this->bookmarks
            ? (bool)$this->bookmarks->where('post_id', $post->id)->count()
            : false;
    }

}
