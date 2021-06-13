{{-- 次のレイアウトを読み込み  resources/views/components/layout.blade.php --}}
<x-layout>
    {{-- ページのtitleを設定 --}}
    <x-slot name="title">
        新規投稿する - My BBS
    </x-slot>

    <div class="back-link">
        {{-- &laquo; <a href="/">æˆ»ã‚‹</a> --}}
        &laquo; <a href="{{ route('posts.index') }}">戻る</a>
    </div>
    <h1>新規投稿する</h1>

    <form action="{{ route('posts.store') }}" method="post">
        {{-- csrf対策：次のトークンが付与される  <input type="hidden" name="_token" value="I3BEimcD9SIdR0G2XeEyJqTeAnhPBGRWRrbfyNaJ"><label> --}}
        @csrf

        <div class="form-group">
            <label>
                タイトル
                {{--  old()  バリデーションに引っかかったとき、記述していた内容を引き継いで表示できる（同じ入力をしなくてもいいようにできる）old('')と ※name="" は同じ内容にする --}}
                <input type="text" name="title" value="{{ old('title')}}">
            </label>

            {{-- バリデーションに引っかかった場合のメッセージ --}}
            @error('title')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>
                本文
                <textarea name="body" id="" cols="" rows="">{{ old('body') }}</textarea>
            </label>

            {{-- バリデーションに引っかかった場合のメッセージ --}}
            @error('body')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-button">
            <button>追加</button>
        </div>

    </form>
</x-layout>
