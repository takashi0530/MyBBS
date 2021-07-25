{{-- 次のレイアウトを読み込み  resources/views/components/layout.blade.php --}}
<x-layout>
    {{-- ページのtitleを設定 --}}
    <x-slot name="title">
        My BBS
    </x-slot>

    <h1>
        <span>My BBS</span>
        <a href="{{ route('posts.create') }}">[新規投稿]</a>
    </h1>

    <p>投稿を検索</p>
    <form method="post" action="{{ route('posts.search') }}" class="comment-form">
        {{-- フォームは必ず@csrfをつける --}}
        @csrf
        <input type="text" name="search_title">
        <button>検索</button>
    </form>

    <ul>
        @forelse ($posts as $post)
            <li>

                {{-- 通常のリンク指定方法 --}}
                {{-- <a href="/posts/{{ $index }}"> --}}
                    {{-- {{ $post }} --}}
                {{-- </a> --}}

                {{-- ルートに名前をつけた場合のリンク指定方法 パラメーターは第２引数で指定する--}}
                <a href="{{ route('posts.show', $post->id) }}">
                    {{ $post->title }}
                </a>

            </li>
        @empty
            <li>postがありません</li>
        @endforelse
    </ul>
</x-layout>
