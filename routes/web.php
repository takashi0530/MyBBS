<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 投稿一覧画面表示
Route::get('/', [PostController::class, 'index'])
    ->name('posts.index');

// 通常のidを渡す方法
// Route::get('/posts/{id}', [PostController::class, 'show'])
//     ->name('posts.show');

// Implicit Binding の仕組みを使ってモデルと紐付ける方法   ※URLからわたされたidをもとに暗黙的にモデルのデータを結びつけてくれる
// 投稿個別ページ表示
Route::get('/posts/{post}', [PostController::class, 'show'])
    ->name('posts.show')
    // postのパラメーターを数字のみしか受け付けないという制限をつける → 文字列はスルーされるため create が渡ってきてもスルーする
    ->where('post', '[0-9]+');

// 新規投稿ページ表示
Route::get('/posts/create', [PostController::class, 'create'])
    ->name('posts.create');


// 新規投稿ページから投稿したとき  ※データを新規作成するときはPOST形式
Route::post('/posts/store', [PostController::class, 'store'])
    ->name('posts.store');

// 投稿編集の表示
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])
    ->name('posts.edit')
    ->where('post', '[0-9]+');

// 投稿編集ページから更新ボタンを押したとき   ※データの一部を更新するときは、POST形式ではなくてPATCH形式にする
Route::patch('/posts/{post}/update', [PostController::class, 'update'])
    ->name('posts.update')
    ->where('post', '[0-9]+');

// 投稿詳細ページから削除ボタンを押したとき ※データの削除をする場合はdelete形式
Route::delete('/posts/{post}/destroy', [PostController::class, 'destroy'])
    ->name('posts.destroy')
    ->where('post', '[0-9]+');

Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
    ->name('comments.store')
    ->where('post', '[0-9]+');

// 投稿詳細ページのコメント一覧にある[X]削除ボタンを押したとき
Route::delete('/comments/{comment}/destroy', [CommentController::class, 'destroy'])
    ->name('comments.destroy')
    ->where('comment', '[0-9]+');


// 投稿検索
Route::post('/', [PostController::class, 'search'])
    ->name('posts.search');
