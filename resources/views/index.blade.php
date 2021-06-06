<?php
    //PHP print_r()を見やすく整形する         (第2引数にラベルの文字列を渡す, 第3引数にtrueを渡せばvar_dumpで出力）
    //PHP print_r()を見やすく整形する (第2引数にラベルの文字列を渡す, 第3引数にtrueを渡せばvar_dumpで出力）
    function pr($var, $label = null, $dir = null, $dump_flg = false) {
        $dbg = debug_backtrace();
        $label_str = '';
        if ($label) {
            $label_str = '<span style="background-color: #fff6a1; font-weight: normal; display: inline-block; margin-bottom: 10px; font-size: 11px;">▼ ' . $label . '</span>';
        }
        if ($dir) {
            $label_str = '<div style="display: flex; justify-content: space-between; margin: 0 0 8px 0"><span style="background-color: #fff6a1; font-weight: normal; display: inline-block; font-size: 11px;">▼ ' . $label . '</span><span style="background-color: #; font-weight: normal; display: inline-block; font-size: 11px;">【' . $dbg[0]['line']. '行　' . $dbg[0]['file'] . '】</span></div>';
        }
        if (!isset($var) || $var === null || $var === false || $var === '' || $var === 0 || $var === true || $dump_flg == true) {
            echo '<pre style="white-space:pre; font-family: monospace; font-size:12px; border:3px double #EE5555; margin:10px; padding:5px;"><code>';
            echo $label_str;
            var_dump($var);
            echo '</code></pre>';
        } else {
            echo '<pre style="white-space:pre; font-family: monospace; font-size:12px; border:3px double rgb(61, 140, 231); margin:8px; padding:5px;"><code>';
            echo $label_str;
            print_r($var);
            echo '</code></pre>';
        }
    }
// pr($posts, '$posts', 1, 0);
?>
<x-layout>
<x-slot name="title">
        My BBS
    </x-slot>


    <h1>My BBS</h1>
    <ul>
        @forelse ($posts as $post)
            <li>

                {{-- 通常のリンク指定方法 --}}
                {{-- <a href="/posts/{{ $index }}">
                    {{ $post }}
                </a> --}}

                {{-- ルートに名前をつけた場合のリンク指定方法 パラメーターは第２引数で指定する--}}
                <a href="{{ route('posts.show', $post->id) }}">
                    {{ $post->title }}
                </a>

            </li>
        @empty
            <li>postがありません</li>
        @endforelse
    </ul>
</x-layout>
