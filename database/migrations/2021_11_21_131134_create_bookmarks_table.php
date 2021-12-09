<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookmarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();

            // ブックマークしたユーザーID
            $table->unsignedBigInteger('user_id');

            // ブックマークした投稿ID
            $table->unsignedBigInteger('post_id');
            // ブックマークした投稿IDの外部キー
            // $table
            //     ->foreign('post_id')
            //     ->references('id')
            //     ->on('posts');
                // ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookmarks');
    }
}
