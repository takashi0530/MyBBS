<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div id="app">
        <example-component></example-component>
        <bookmark-component></bookmark-component>
    </div>
    {{-- キャッシュによる未反映を防止するためにidをふる {{ mix('ファイル名') }} --}}
    <script src="{{ mix('js/app.js') }}"></script>
    {{-- <script src="js/app.js"></script> --}}
</body>
</html>
