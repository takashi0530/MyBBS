<x-layout>
    <x-slot name="title">
        {{ $post->title }} - My BBS
    </x-slot>

    <div class="back-link">
        {{-- &laquo; <a href="/">戻る</a> --}}
        &laquo; <a href="{{ route('posts.index') }}">戻る</a>
    </div>
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->body }}</p>
</x-layout>
