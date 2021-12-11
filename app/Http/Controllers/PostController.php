<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Bookmark;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use App\Library\Validate;

// 定数ファイルを読み込む
use App\Consts\Consts;


class PostController extends Controller
{
    // トップページ
    public function index(Request $request)
    {
        // Postsテーブルの値を全て取得し、order BYでソートする ※以下2つは同じ意味 下が短くかける
        // $posts = Post::orderBy('created_at', 'desc')->get();
        // $posts = Post::latest()->get();

        // ページャーを利用して表示する ※simplePaginateメソッドは常に最後に呼び出す
        // $posts = DB::table('posts')->orderBy('created_at', 'desc')->simplePaginate(3);

        // ?sort=title パラメーター部分を取得
        $sort = $request->sort;

        // 検索した文字列を取得
        $keyword = $request->keyword;

        // タイトルのソートボタンがおされたとき タイトル順
        if ($sort === 'title') {
            $order = 'asc';
        }

        // ソートボタンが押されていない初期表示 もしくは 投稿日のソートボタンがおされたとき 投稿日順
        if ($sort === null || $sort === 'created_at') {
            $sort = 'created_at';
            $order = 'desc';
        }

        // 検索ボタンがおされたとき
        if ($keyword !== null) {
            $posts = DB::table('posts')
                ->where('title', 'like', '%' . $keyword . '%')
                ->orderBy($sort, $order)
                ->paginate(4);
        }

        // 検索ボタンが押されていないとき
        if ($keyword === null) {
            $posts = DB::table('posts')
                ->orderBy($sort, $order)
                ->paginate(4);
        }

        return view('index')
            ->with([
                'posts'   => $posts,
                'sort'    => $sort,
                'keyword' => $keyword
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

        // 投稿に紐付いた画像を取得 TODO 2021/08/17
        // $post_images = DB::table('post_images')
        //     ->where('post_id', '=', $post->id);
        // pr($post->postImage);

        return view('posts.show')
            ->with([
                'post' => $post,
                'post_images' => $post->postImage
            ]);
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

        // アップロードしたファイルをサーバーに保存する（名前はランダム）
        // $request->file('file')->store('');

        // アップロードしたもともとのファイル名を取得
        // $file_name = $request->file('file')->getClientOriginalName();

        // アップロードしたファイルに名前をつけて保存する
        // $request->file('file')->storeAs('public', $file_name);

        // アップロードした複数ファイルを配列に代入
        $files = $request->file('file');

        // アップロードされたファイルがない場合トップページへリダイレクト
        if ($files === null) {
            return redirect()
                ->route('posts.index');
        }

        // 同時アップロード数を検証
        if (count($files) > Consts::ALLOWED_FILE_UPLOAD_COUNT) {
            return back()
                ->withInput()
                ->with('error_message', '同時にアップロードできる画像は5枚までです');
        }

        // アップロードファイルのバリデーション処理
        foreach ($files as $key => $file) {

            // ファイルを検証する
            list($result, $error_message) = Validate::checkImage($file);

            if (!$result) {
                return back()
                    ->withInput()
                    ->with('error_message', $error_message);
            }
        }

        // アップロードした複数ファイルをひとつずつサーバーに保存する
        foreach ($files as $key => $file) {
            $file_count = $key + 1;

            // ファイル名   ex) 20210816-105250-3.gif
            $file_name = date('Ymd-His-') . $file_count . '.' . $file->getClientOriginalExtension();

            // 画像をサーバに保存する
            $file->storeAs('public', $file_name);

            // ファイルのアップロード情報をINSERTするための配列を準備
            $insert_data[$key]['post_id']    = $post->id;
            $insert_data[$key]['name']       = $file_name;
            $insert_data[$key]['type']       = $file->getMimeType();
            $insert_data[$key]['size']       = $file->getSize();
            $insert_data[$key]['created_at'] = date('Y-m-d H:i:s');
            $insert_data[$key]['updated_at'] = date('Y-m-d H:i:s');
        }

        // 複数のファイルのアップロード情報をまとめてINSERTする
        DB::table('post_images')
            ->insert($insert_data);

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

    // 特定の投稿をブックマークに登録する
    public function bookmark(Post $post, Request $request)
    {
        // ajax通信でない場合はトップへリダイレクト
        if (!$request->ajax()) {
            return redirect()
                ->route('posts.index');
        }

        // ブックマークに登録する
        $bookmark = new Bookmark();
        $bookmark->post_id = $post->id;
        $bookmark->user_id = 0; // 現在ユーザー機能はないため仮の0にする
        $bookmark->save();

        return [
            // 直前にインサートしたbookmarks.id
            'bookmark_id' => $bookmark->id,
            'post_id'     => $post->id,
            'result'      => true,
            'comment'     => 'ブックマークを登録しました',
        ];
    }

    // 特定の投稿のブックマークを解除する
    public function unbookmark(Post $post, Request $request)
    {
        // ajax通信でない場合はトップへリダイレクト
        if (!$request->ajax()) {
            return redirect()
                ->route('posts.index');
        }

        $bookmark = new Bookmark();

        // 削除するbookmark.idを取得する
        $bookmark_id = $bookmark
            ->where('post_id', $post->id)
            ->value('id');

        // ブックマークを解除する
        $result = $bookmark
            ->where('post_id', $post->id)
            ->delete();

        if (!$result) {
            return [
                'result'      => false,
                'comment'     => 'ブックマークの解除に失敗しました'
            ];
        }

        return [
            'bookmark_id' => $bookmark_id,
            'post_id'     => $post->id,
            'result'      => true,
            'comment'     => 'ブックマークを解除しました'
        ];
    }


    // ブックマークの登録もしくはブックマークの解除の共通メソッド (使用していない)
    public function bookmark_or_unbookmark(Post $post, Request $request)
    {
        // ajax通信でない場合はトップへリダイレクト
        if (!$request->ajax()) {
            return redirect()
                ->route('posts.index');
        }

        $result = '';
        $bookmark = new Bookmark();

        // bookmarksテーブルにpost_idがすでにが存在しているかのチェック
        $bookmark_check = $bookmark->where('post_id', $post->id)->exists();

        // 既にブックマーク済みならブックマークを削除する
        if ($bookmark_check) {
            $bookmark->where('post_id', $post->id)->delete();
            $result = 'ブックマークを解除しました';
        }

        // まだブックマークをしていなければブックマークする
        if (!$bookmark_check) {
            $bookmark->post_id = $post->id;
            $bookmark->user_id = 0; // 現在ユーザー機能はないため仮の0にする
            $bookmark->save();
            $result = 'ブックマークを登録しました';
        }

        return [
            'post_id' => $post->id,
            'comment' => $result,
            'check'   => $bookmark_check
        ];
    }

}
