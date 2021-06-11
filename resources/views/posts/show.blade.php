<x-layout>
    <x-slot name="title">
        {{ $post->title }} - My BBS
    </x-slot>

    <div class="back-link">
        &laquo; <a href="{{ route('posts.index') }}">??</a>
    </div>

    <h1>
        <span>{{ $post->title }}</span>
        <a href="{{ route('posts.edit', $post)}}">[Edit]</a>
        <form method="post" action="{{ route('posts.destroy', $post) }}" id="delete_post">

            {{-- データを削除するときは、DELETE形式で送信する必要があるため以下を追記 --}}
            @method('DELETE')

            @csrf
            <button class="button">[X]</button>
        </form>
    </h1>

    <p>{!! nl2br(e($post->body)) !!}</p>

    <script>
        'use strict'
        {
            document.getElementById('delete_post').addEventListener('submit', e=> {
                e.preventDefault();

                if (!confirm('削除してもいいですか？')) {
                    return;
                }

                e.target.submit();
            })
        }
    </script>
</x-layout>
