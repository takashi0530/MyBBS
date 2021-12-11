{{-- 次のレイアウトを読み込み  resources/views/components/layout.blade.php --}}
<x-layout>
    {{-- ページのtitleを設定 --}}
    <x-slot name="title">
        My BBS
    </x-slot>

    <h1 class="mb-8 title-bar">
        <span>
            <a href="{{ route('posts.index') }}">My BBS</a>
        </span>
        <div>
            <a href="{{ route('bookmark.index') }}">
                <button class="bg-white hover:bg-gray-100 text-gray-800 py-3 px-4 border border-gray-600 rounded-sm shadow text-sm">
                    お気に入り一覧
                </button>
            </a>
            <a href="{{ route('posts.create') }}">
                <button class="bg-white hover:bg-gray-100 text-gray-800 py-3 px-4 border border-gray-600 rounded-sm shadow text-sm ml-2">
                    新規登録
                </button>
            </a>
        </div>
    </h1>

    {{-- <p>投稿を検索</p> --}}
    <form method="get" action="{{ route('posts.index', Request::query()) }}" class="comment-form mb-8">
        <input type="text" name="keyword" value="{{ $keyword }}" placeholder="投稿を検索" class="border border-gray-600 rounded-sm shadow">
        <button class="bg-white hover:bg-gray-100 text-gray-800 py-3 px-4 border border-gray-600 rounded-sm shadow text-sm w-2/12 ml-2">
            検索
        </button>
        @if ($sort === 'title')
            <input type="hidden" name="sort" value="title">
        @elseif ($sort === 'created_at')
            <input type="hidden" name="sort" value="created_at">
        @endif
    </form>

    <ul class="mb-12 divide-y-2">
        <div class="flex">
            <div>
                <a href="{{ route('posts.index', array_merge(Request::query(), ['sort' => 'title'])) }}">タイトル順</a>
            </div>
            <div class="mr-0 ml-auto">
                <a href="{{ route('posts.index', array_merge(Request::query(), ['sort' => 'created_at'])) }}">投稿日順</a>
            </div>
        </div>
        @forelse ($posts as $post)
            <li class="">
                {{-- ルートに名前をつけた場合のリンク指定方法 パラメーターは第２引数で指定する--}}
                <a href="{{ route('posts.show', $post->id) }}">
                    {{ $post->title }}
                </a>
                <span>
                    {{ $post->created_at }}
                </span>
            </li>
        @empty
            <li>【投稿がありません】</li>
        @endforelse
    </ul>

    <div class="text-right mb-8">
        <a href="{{ route('csv.download') }}">
            <button class="bg-white hover:bg-gray-100 text-gray-800 py-3 px-4 border border-gray-600 rounded-sm shadow text-sm w-3/12">
                CSVダウンロード
            </button>
        </a>
    </div>

    {{ $posts->appends(['sort' => $sort, 'keyword' => $keyword])->links() }}
</x-layout>
