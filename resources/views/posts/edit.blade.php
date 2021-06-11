<x-layout>
    <x-slot name="title">
        Edit Post - My BBS
    </x-slot>

    <div class="back-link">
        {{-- &laquo; <a href="/">æˆ»ã‚‹</a> --}}
        &laquo; <a href="{{ route('posts.show', $post) }}">戻る</a>
    </div>
    <h1>Edit New Post</h1>

    <form action="{{ route('posts.update', $post)}}" method="post">
        @method('PATCH')
        @csrf           {{-- csrf対策：次のトークンが付与される  <input type="hidden" name="_token" value="I3BEimcD9SIdR0G2XeEyJqTeAnhPBGRWRrbfyNaJ"><label> --}}

        <div class="form-group">
            <label>
                タイトル
                {{-- oldをつけることですでに入力済みの値がある場合、それを表示してくれる --}}
                <input type="text" name="title" value="{{ old('title', $post->title)}}">
            </label>
            @error('title')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>
                本文
                <textarea name="body" id="" cols="" rows="">{{ old('body', $post->body) }}</textarea>
            </label>
            @error('body')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-button">
            <button>更新</button>
        </div>


    </form>
</x-layout>
