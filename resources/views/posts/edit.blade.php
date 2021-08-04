{{-- 次のレイアウトを読み込み  resources/views/components/layout.blade.php --}}
<x-layout>
    <x-slot name="title">
        投稿を編集する - My BBS
    </x-slot>

    <div class="back-link">
        {{-- 戻り先は記事詳細画面 posts.show --}}
        &laquo; <a href="{{ route('posts.show', $post) }}">戻る</a>
    </div>
    <h1>投稿を編集する</h1>

    <form action="{{ route('posts.update', $post)}}" method="post">
        {{-- webの決まりとしてこれから送信するものはPATCH形式である、と明示的に指示する必要がある   ※formタグはpatch形式に対応していないためmethod="post"のままでok --}}
        @method('PATCH')
        @csrf           {{-- csrf対策：次のトークンが付与される  <input type="hidden" name="_token" value="I3BEimcD9SIdR0G2XeEyJqTeAnhPBGRWRrbfyNaJ"><label> --}}

        <div class="form-group">
            <label>
                タイトル
                {{-- old をつけることですでに入力済み(post済み)の値がある場合、それを表示してくれる。第２引数に値を渡すことでpostされたデータ がなければ指定した値を表示することができる（※編集画面を開いたら、空欄とならずに、現在のDB情報が表示される） --}}
                {{-- <input type="text" name="title" value="{{ old('title', $post->title)}}"> --}}
                <input type="text" name="title" value="{{ old('title', $post->title)}}" class="border border-gray-600 rounded-sm shadow">

            </label>
            @error('title')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>
                本文
                {{-- old をつけることですでに入力済み(post済み)の値がある場合、それを表示してくれる。第２引数に値を渡すことでpostされたデータ がなければ指定した値を表示することができる（※編集画面を開いたら、空欄とならずに、現在のDB情報が表示される） --}}
                {{-- <textarea name="body" id="" cols="" rows="">{{ old('body', $post->body) }}</textarea> --}}
                <textarea name="body" id="" cols="" rows="" class="border border-gray-600 rounded-sm shadow">{{ old('body', $post->body) }} </textarea>

            </label>
            @error('body')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-button">
            {{-- <button>更新</button> --}}
            <button class="bg-white hover:bg-gray-100 text-gray-800 py-3 px-4 border border-gray-600 rounded-sm shadow text-sm w-2/12">
                更新
            </button>
        </div>
    </form>
</x-layout>
