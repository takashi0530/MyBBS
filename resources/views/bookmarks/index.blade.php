<x-layout>
    <x-slot name="title">
        お気に入りの投稿一覧 - My BBS
    </x-slot>
    <div class="back-link">
        &laquo; <a href="{{ route('posts.index') }}">戻る</a>
    </div>
    <h1>お気に入り登録している投稿一覧</h1>
    <ul class="mb-12">
        <div id="app" v-cloak>
            @forelse ($bookmarks as $bookmark)
                <li>
                    <a href="{{ route('posts.show', $bookmark->post->id) }}">
                        {{ $bookmark->post->title }}
                    </a>
                    {{-- お気に入りボタン --}}
                    <bookmark-component
                        :initial-is-bookmarked-by="@json($bookmark->post->isBookmarkedBy($bookmark->post))"
                        endpoint="{{ route('posts.bookmark', $bookmark->post) }}"
                        class="ml-auto"
                    >
                    </bookmark-component>
                </li>
            @empty
                <li>
                    【お気に入り登録している投稿はありません】
                </li>
            @endforelse
        </div>
    </ul>
</x-layout>
