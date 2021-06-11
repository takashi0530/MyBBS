<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{

    // private $posts = [
    //     'title a',
    //     'title b',
    //     'title c',
    // ];


    // トップページ
    public function index()
    {
        // Postsテーブルの全てのレコードを取得する
        // $posts = Post::all();

        // Postsテーブルの値を全て取得し、order BYでソートする ※以下2つは同じ意味 下が短くかける
        // $posts = Post::orderBy('created_at', 'desc')->get();
        $posts = Post::latest()->get();

        // sqlクエリの確認方法
        // $sql = Post::where('id', 1)->toSql();

        return view('index')
            ->with(['posts' => $posts]);
    }


    // 詳細個別ページ  （Implicit Binding を使用する場合）
    //  ※暗黙的な紐付けをするには、ルーティングのパラメーターの名前(post)と引数$postを同じ名前にする必要がある   ※さらに引数の型も指定が必要
    // Implicit Binding の仕組みを使ってモデルと紐付ける方法   ※URLからわたされたidをもとに暗黙的にモデルのデータを結びつけてくれる
    public function show(Post $post)
    {
        // Implicit Binding  を使用すると、以下の処理が不要になる
        // $post = Post::findOrFail($id);

        return view('posts.show')
            ->with(['post' => $post]);
    }


    // 追加ページ
    public function create()
    {
        return view('posts.create');
    }


    // 記事投稿
    public function store(PostRequest $request)
    {
        // Postモデル（クラス）をインスタンス化
        $post = new Post();

        // タイトルを代入
        $post->title = $request->title;

        // 本文を代入
        $post->body = $request->body;

        // レコードをINSERTする
        $post->save();

        // トップページへリダイレクト
        return redirect()
            ->route('posts.index');
    }

    // 記事編集
    public function edit(Post $post)
    {
        // Implicit Binding  を使用すると、以下の処理が不要になる
        // $post = Post::findOrFail($id);

        return view('posts.edit')
            ->with(['post' => $post]);
    }


    // 記事更新処理
    public function update(PostRequest $request, Post $post)
    {
        // タイトルを代入
        $post->title = $request->title;

        // 本文を代入
        $post->body = $request->body;

        // レコードをINSERTする
        $post->save();

        // トップページへリダイレクト
        return redirect()
            ->route('posts.show', $post);
    }

    // 投稿詳細ページから投稿の削除ボタンをおしたとき
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()
            ->route('posts.index');
    }



    // 詳細個別ページ （通常）
    // public function show($id) {

    //     // postテーブルのidを指定してfindすると、該当のレコードを取得できる
    //     // $post = Post::find($id);

    //     // postテーブルのidを指定してfindすると、該当のレコードを取得できる  findOrFail($id)とすることで、存在しないページでエラーを非表示にできnotfoundにできる
    //     $post = Post::findOrFail($id);

    //     return view('posts.show')
    //         ->with(['post' => $post]);
    // }



}
