{{-- 次のレイアウトを読み込み  resources/views/components/layout.blade.php --}}
<x-layout>
    {{-- ページのtitleを設定 --}}
    <x-slot name="title">
        My BBS
    </x-slot>

    <h1>
        <span><a href="{{ route('posts.index') }}">My BBS</a></span>
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
        <li>
            <a href="{{ route('posts.index') }}?sort=title">タイトル順</a>
            <span><a href="{{ route('posts.index') }}?sort=created_at">投稿日順</a></span>
        </li>
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

                <span>{{ $post->created_at }}</span>

            </li>
        @empty
            <li>postがありません</li>
        @endforelse

    </ul>
    {{-- {{ $posts->appends(['sort' => $sort])->links('pagination::bootstrap-4') }} --}}
    {{-- {{ $posts->appends(['sort' => $sort])->links('pagination::tailwind') }} --}}
    {{ $posts->appends(['sort' => $sort])->links() }}
</x-layout>
