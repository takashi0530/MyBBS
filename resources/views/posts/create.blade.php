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

    <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
        {{-- csrf対策：次のトークンが付与される  <input type="hidden" name="_token" value="I3BEimcD9SIdR0G2XeEyJqTeAnhPBGRWRrbfyNaJ"><label> --}}
        @csrf

        <div class="form-group">
            <label>
                タイトル
                {{--  old()  バリデーションに引っかかったとき、記述していた内容を引き継いで表示できる（同じ入力をしなくてもいいようにできる）old('')と ※name="" は同じ内容にする --}}
                <input type="text" name="title" value="{{ old('title')}}" class="border border-gray-600 rounded-sm shadow">
            </label>

            {{-- バリデーションに引っかかった場合のメッセージ --}}
            @error('title')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>
                本文
                <textarea name="body" id="" cols="" rows="" class="border border-gray-600 rounded-sm shadow">{{ old('body') }}</textarea>
            </label>

            {{-- バリデーションに引っかかった場合のメッセージ --}}
            @error('body')
                <div class="error">{{ $message }}</div>
            @enderror

            {{-- アップロード --}}
            <input type="file" name="file[]" accept=".jpg, .jpeg, .gif, .png" multiple>

            {{-- バリデーションに引っかかった場合のメッセージ --}}
            @if (session('error_message'))
                <div class="error ">{{ session('error_message') }}</div>
            @endif

        </div>

        <div class="form-button">
            <button class="bg-white hover:bg-gray-100 text-gray-800 py-3 px-4 border border-gray-600 rounded-sm shadow text-sm w-2/12">追加</button>
        </div>

    </form>
</x-layout>
