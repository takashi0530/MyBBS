
{{-- 次のレイアウトを読み込み  resources/views/components/layout.blade.php --}}
<x-layout>

    {{-- ページのtitleを設定 --}}
    <x-slot name="title">
        {{ $post->title }} - My BBS
    </x-slot>

    <div class="back-link">
        &laquo; <a href="{{ route('posts.index') }}">戻る</a>
    </div>

    <h1>
        <span>{{ $post->title }}</span>

        {{-- 投稿の編集ボタン ※$postのデータをrouteに渡している --}}
        <a href="{{ route('posts.edit', $post)}}">
            <i class="fas fa-edit"></i>
        </a>

        <?php

        ?>
        {{-- お気に入り登録ボタン --}}
        <div id="app">
            {{-- vueの親コンポーネント --}}
            <bookmark-component
                {{-- 現在ブックマーク済みかどうかの値が入る（bool） --}}
                :initial-is-bookmarked-by='@json($post->isBookmarkedBy($post))'
                {{-- 非同期通信先のURL 通信先で現在の投稿に紐づくブックマーク状況を取得するため、第2引数でpostモデルを渡す --}}
                endpoint="{{ route('posts.bookmark', $post) }}"
            ></bookmark-component>
        </div>

        <?php
            // pr($post);
        ?>


        {{-- 記事削除ボタン [X] --}}
        <form method="post" action="{{ route('posts.destroy', $post) }}" id="delete_post">
            {{-- データを削除するときは、DELETE形式で送信する必要があるため以下を追記 --}}
            @method('DELETE')
            {{-- フォームは必ず@csrfをつける --}}
            @csrf
            <button class="button">
                <i class="far fa-times-circle"></i>
            </button>
        </form>
    </h1>


    <p>{!! nl2br(e($post->body)) !!}</p>

    {{-- 投稿画像の表示 --}}
    @forelse ($post_images as $post_image)
        @if (file_exists('storage/' . $post_image->name))
            @if ($loop->first)
                <div class="flex space-x-8 space-y-8 items-center place-items-center justify-center flex-wrap">
            @endif
            <div><img src="{{ asset('storage/' . $post_image->name) }}" alt="投稿画像" class="w-52"></div>
            @if ($loop->last)
                </div>
            @endif
        @else
            <p>【画像が存在しません】</p>
        @endif
    @empty
        <p class="my-5">【投稿された画像はありません】</p>
    @endforelse

    <h2>コメント</h2>
    <div class="mb-5">
        {{-- routeの第２引数$postはパラメーターとして渡せる --}}
        <form method="post" action="{{ route('comments.store', $post) }}" class="comment-form">
            {{-- フォームは必ず@csrfをつける --}}
            @csrf
            {{-- <input type="text" name="body"> --}}
            <input type="text" name="body" class="border border-gray-600 rounded-sm shadow">
            {{-- <button>コメントを追加</button> --}}
            <button class="bg-white hover:bg-gray-100 text-gray-800 py-3 px-4 border border-gray-600 rounded-sm shadow text-sm">
                コメントを追加
            </button>
        </form>
    </div>
    <ul>

        {{-- created_atで降順に並べる --}}
        @forelse ($post->comments()->latest()->get() as $comment)
            <li class="justify-between">
                {{ $comment->body }}

                {{-- コメント削除ボタン [X] --}}
                <form action="{{ route('comments.destroy', $comment)}}" method="post" class="delete-comment">
                    @method('delete')
                    {{-- フォームは必ず@csrfをつける --}}
                    @csrf
                    <button class="button">
                        <i class="fas fa-backspace"></i>
                    </button>
                </form>
            </li>
        @empty
            <li>
                【コメントはありません】
            </li>
        @endforelse

    </ul>

    <script>
        'use strict'
        {
            document.getElementById('delete_post').addEventListener('submit', e=> {
                e.preventDefault();

                if (!confirm('削除してもいいですか？')) {
                    return;
                }

                e.target.submit();
            });

            document.querySelectorAll('.delete-comment').forEach(form => {
                form.addEventListener('submit', e => {
                    e.preventDefault();

                    if (!confirm('コメントを削除してもいいですか？')) {
                        return;
                    }

                    form.submit();
                });
            });
        }
    </script>
</x-layout>
