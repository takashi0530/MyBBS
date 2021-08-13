<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_images', function (Blueprint $table) {
            $table->id();

            // postsテーブルのidと紐付け、同じ型にする
            $table->unsignedBigInteger('post_id');
            // 画像名
            $table->string('name');
            // 画像タイプ（MIME）
            $table->string('type');
            // 画像サイズ
            $table->string('size');

            $table->timestamps();

            // postsテーブルに存在しないidが、post_imagesテーブルのpost_idに入り込まないように外部キー制約をつける
            $table
                ->foreign('post_id')    // post_imagesテーブルのpost_id
                ->references('id')      // postsテーブルのid
                ->on('posts')           // postsテーブル
                // postsテーブルでレコードが削除されたら関連するコメントも削除されるように onDeleteを設定する
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_images');
    }
}
