<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>


    {{-- CDN bootstrap5 読み込み--}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous"> --}}

    {{-- CDN tailwindcss 読み込み --}}
    {{-- <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet"> --}}

    {{-- tailwindcss 読み込み --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- url() は、指定されたパスへ、アプリのルートからドメインを含めた完全なURLを生成してくれる関数    どの階層にいてもcssを適用できるようにする --}}
    <link rel="stylesheet" href="{{ url('css/style.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

</head>
<body>

    <div class="container">
        {{ $slot }}
    </div>

    {{-- vueコンポーネント   resources/js/app.js  の読み込み --}}
    <script src="{{ asset(mix('/js/app.js')) }}"></script>

</body>
</html>
