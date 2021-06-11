<x-layout>
    <x-slot name="title">
        Add New Post - My BBS
    </x-slot>

    <div class="back-link">
        {{-- &laquo; <a href="/">æˆ»ã‚‹</a> --}}
        &laquo; <a href="{{ route('posts.index') }}">戻る</a>
    </div>
    <h1>Add New Post</h1>

    <form action="{{ route('posts.store') }}" method="post">
        @csrf           {{-- csrf対策：次のトークンが付与される  <input type="hidden" name="_token" value="I3BEimcD9SIdR0G2XeEyJqTeAnhPBGRWRrbfyNaJ"><label> --}}

        <div class="form-group">
            <label>
                タイトル
                <input type="text" name="title" value="{{ old('title')}}">
            </label>
            @error('title')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>
                本文
                <textarea name="body" id="" cols="" rows="">{{ old('body') }}</textarea>
            </label>
            @error('body')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-button">
            <button>追加</button>
        </div>


    </form>
</x-layout>
