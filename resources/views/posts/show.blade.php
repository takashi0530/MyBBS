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
        <a href="{{ route('posts.edit', $post)}}">[編集する]</a>

        {{-- 記事削除ボタン [X] --}}
        <form method="post" action="{{ route('posts.destroy', $post) }}" id="delete_post">
            {{-- データを削除するときは、DELETE形式で送信する必要があるため以下を追記 --}}
            @method('DELETE')
            {{-- フォームは必ず@csrfをつける --}}
            @csrf
            <button class="button">[X]</button>
        </form>
    </h1>

    <p>{!! nl2br(e($post->body)) !!}</p>

    <h2>コメント</h2>
        <ul>
            <li>
                {{-- routeの第２引数$postはパラメーターとして渡せる --}}
                <form method="post" action="{{ route('comments.store', $post) }}" class="comment-form">
                    {{-- フォームは必ず@csrfをつける --}}
                    @csrf
                    {{-- <input type="text" name="body"> --}}
                    <input type="text" name="body" class="border border-gray-600 rounded-sm shadow">
                    {{-- <button>コメントを追加</button> --}}
                    <button class="bg-white hover:bg-gray-100 text-gray-800 py-3 px-4 border border-gray-600 rounded-sm shadow text-sm w-2/12">
                        コメントを追加
                    </button>
                </form>
            </li>

            {{-- created_atで降順に並べる --}}
            @foreach ($post->comments()->latest()->get() as $comment)
                <li>
                    {{ $comment->body }}

                    {{-- コメント削除ボタン [X] --}}
                    <form action="{{ route('comments.destroy', $comment)}}" method="post" class="delete-comment">
                        @method('delete')
                        {{-- フォームは必ず@csrfをつける --}}
                        @csrf
                        <button class="button">[x]</button>
                    </form>
                </li>
            @endforeach

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
