<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{

    // コメントの投稿ボタンを押したとき
    public function store(Request $request, Post $post)
    {
        // バリデーション   本文が未入力の場合、もとの画面に差し戻してくれる
        $request->validate([
            'body' => 'required',
        ]);

        // commentモデルのインスタンスを作る
        $comment = new Comment();

        $comment->post_id = $post->id;
        // リクエストで渡ってきたbodyを代入
        $comment->body = $request->body;
        $comment->save();

        return redirect()
            ->route('posts.show', $post);
    }

    // コメントの削除ボタンを押したとき
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()
            ->route('posts.show', $comment->post);
    }
}
