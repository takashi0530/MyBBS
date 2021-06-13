<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            // postsテーブルのidと紐付け、同じ型にする
            $table->unsignedBigInteger('post_id');

            $table->string('body');
            $table->timestamps();

            // postsテーブルに存在しないidが、commentsテーブルのpost_idに入り込まないように外部キー制約をつける
            $table
                ->foreign('post_id')          //commentsテーブのpost_id
                ->references('id')               //postsテーブルのid
                ->on('posts')                   //postsテーブル
                // postsテーブルでレコードが削除されたら関連するコメントも削除されるように onDeleteを設定する
                ->onDelete('cascade');
        });

            // 作成されるテーブル
            // mysql> desc comments;
            // +------------+-----------------+------+-----+---------+----------------+
            // | Field      | Type            | Null | Key | Default | Extra          |
            // +------------+-----------------+------+-----+---------+----------------+
            // | id         | bigint unsigned | NO   | PRI | NULL    | auto_increment |
            // | post_id    | bigint unsigned | NO   | MUL | NULL    |                |
            // | body       | varchar(255)    | NO   |     | NULL    |                |
            // | created_at | timestamp       | YES  |     | NULL    |                |
            // | updated_at | timestamp       | YES  |     | NULL    |                |
            // +------------+-----------------+------+-----+---------+----------------+
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
