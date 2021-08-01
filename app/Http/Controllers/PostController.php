<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
// PostRequestクラスを使用する
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;


class PostController extends Controller
{

    // private $posts = [
    //     'title a',
    //     'title b',
    //     'title c',
    // ];


    // トップページ
    public function index(Request $request)
    {
        // Postsテーブルの全てのレコードを取得する
        // $posts = Post::all();

        // Postsテーブルの値を全て取得し、order BYでソートする ※以下2つは同じ意味 下が短くかける
        // $posts = Post::orderBy('created_at', 'desc')->get();
        // $posts = Post::latest()->get();

        // sqlクエリの確認方法
        // $sql = Post::where('id', 1)->toSql();

        // ページャーを利用して表示する ※simplePaginateメソッドは常に最後に呼び出す
        // $posts = DB::table('posts')->orderBy('created_at', 'desc')->simplePaginate(3);

        $sort = $request->sort;
        pr($sort);

        // タイトルのソートボタンがおされたとき タイトル順
        if ($sort === 'title') {
            $order = 'asc';
        }

        // ソートボタンが押されていない初期表示 もしくは 投稿日のソートボタンがおされたとき 投稿日順
        if ($sort === null || $sort === 'created_at') {
            $sort = 'created_at';
            $order = 'desc';
        }
        // $posts = Post::orderBy($sort, $order)->simplePaginate(4);
        $posts = DB::table('posts')->orderBy($sort, $order)->paginate(4);
        // $posts = Post::paginate(4);

        return view('index')
            ->with([
                'posts' => $posts,
                'sort' => $sort
            ]);
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

    // 詳細個別ページ  （Implicit Binding を使用する場合）
    //  ※暗黙的な紐付けをするには、ルーティングのパラメーターの名前(post)と引数$postを同じ名前にする必要がある   ※さらに引数の型も指定が必要
    // Implicit Binding の仕組みを使ってモデルと紐付ける方法   ※URLからわたされたidをもとに暗黙的にモデルのデータを結びつけてくれる
    public function show(Post $post)
    {
        // Implicit Binding  を使用すると、以下の処理が不要になる (web.phpのルートで指定されたidと該当のレコードが紐付けられ、コントローラー内で$postとして使用することができる)
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
    // 型をPostRequestとすることでstoreメソッドが実行される前に、PostRequestクラスのバリデーションが実行される仕組み  app/Http/Request/PostRequest.php
    public function store(PostRequest $request)
    {
        // PostRequestを使用せずにコントローラー内でバリデーションを行いたいなら以下を記述する
        // $request->validate([
        //     'title' => 'required|min:3',
        //     'body' => 'required',
        // ], [
        //     'title.required' => 'タイトルは必須です',
        //     'title.min' => ':min 文字以上入力してください',
        //     'body.required' => '本文は必須です',
        // ]);

        // Postモデル（クラス）をインスタンス化       ※Implicit bindingで引数$postが渡ってきていないため、Postのインスタンス化が必要
        $post = new Post();

        // postされたタイトルを代入
        $post->title = $request->title;

        // postされた本文をを代入
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
        // Implicit Binding  を使用すると、以下の処理が不要になる (web.phpのルートで指定されたidと該当のレコードが紐付けられ、コントローラー内で$postとして使用することができる)
        // $post = Post::findOrFail($id);

        return view('posts.edit')
            ->with(['post' => $post]);
    }


    // 記事更新処理   （投稿編集ページから更新ボタンを押したとき）
    public function update(PostRequest $request, Post $post)
    {
        // タイトルを代入
        $post->title = $request->title;

        // 本文を代入
        $post->body = $request->body;

        // 新しい投稿のレコードをINSERTする
        $post->save();

        // トップページへリダイレクト
        return redirect()
            ->route('posts.show', $post);
    }

    // 投稿詳細ページから投稿の削除ボタンをおしたとき
    public function destroy(Post $post)
    {
        // 該当の投稿のレコードを削除する
        $post->delete();

        return redirect()
            ->route('posts.index');
    }

    // 投稿を検索
    public function search(Request $request)
    {
        // postされた検索ワードを取得
        $search_title = $request->input('search_title');

        // 検索ワードに該当するレコードを全て取得する
        $posts = DB::table('posts')
            ->where('title', 'like', '%' . $search_title . '%')
            ->latest()
            ->get();

        return view('index')
            ->with(['posts' => $posts]);
    }

}
