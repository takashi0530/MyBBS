<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MailSendController;
use App\Http\Controllers\TestCsvController;
use App\Http\Controllers\CsvController;

// サービスコンテナテスト
use App\Http\Controllers\TestController;

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


// ログテスト
Route::get('/log', function() {
    // [2021-08-30 15:14:14] local.INFO: something happens!
    logger()->info('something happens!');
    Log::channel('stack')->error('なにかエラーが発生しました');
});


// メール送信テスト （Mailファサードを使用する場合）
Route::get('/mail', [MailSendController::class, 'index'])
    ->name('mail.index');

// メール送信テスト （Mailableクラスを使用する場合）
Route::get('/mail_send', [MailSendController::class, 'send'])
    ->name('mail.send');

// サービスコンテナテスト
// app()->bind('myName', function() {
//     return 'にしむらです';
// });

// dd(app());
// $name = app()->make('myName');
// dd($name);

// サービスコンテナテスト
Route::get('/test', [TestController::class, 'index']);

// CSVダウンロード テスト
Route::get('/test_csv', [TestCsvController::class, 'index']);

// 投稿記事のCSVダウンロード
Route::get('/csv_download', [CsvController::class, 'index'])
    ->name('csv.download');

// vueコンポーネントテスト
Route::get('/vue_test', [TestController::class, 'vue_test']);
