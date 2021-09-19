<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class TestController extends Controller
{


    public function index()
    {
        pr('aaa');
        // 依存関係がある場合における、通常のクラスのインスタンス化方法
        // $classB = new ClassB();
        // $classA = new ClassA($classB);


        // サービスコンテナを利用して自動で依存関係を解消し、インスタンス化する方法  ※以下全てインスタンス化する記述となり、同じ結果となる
        // $classA = app()->make(ClassA::class);                                             //スタンダードな記述
        // $classA = \Illuminate\Container\Container::getInstance()->make(ClassA::class);    // コンテナを取ってきてインスタンスを作るよ
        // $classA = app()->resolve(ClassA::class);                                          // コンテナがクラスの依存を解決するよ ※使えない
        // $classA = resolve(ClassA::class);                                                 // クラスの依存を解決するよ
        // $classA = \Illuminate\Foundation\Application::getInstance()->make(ClassA::class); // アプリ本体を取ってきてインスタンスを作るよ
        $classA = app(ClassA::class);                                                        // インスタンスくれ ※一番カンタンな記述


    }


}

class ClassA
{
    public function __construct(ClassB $classB)
    {
        Log::info('ClassAのインスタンスが完了しました');
        // \Illuminate\Support\Facades\Log::info('ClassAのインスタンスが完了しました');
    }
}


class ClassB
{
    public function __construct()
    {
        Log::info('ClassBのインスタンスが完了したよ！');
    }
}




// DIパターン（デザインパターン）で記述されたコード例

// 使う側 クライアント
class Client
{
    private $service;

    // 外部でServiceオブジェクトが生成され、Clientクラスに注入される。これがDIパターン
    // DIパターン その１ オブジェクトの生成と使用が分離されている
    // DIパターン その２ クライアントがサービスを呼ぶのではなく、サービスが外部からクライアントに注入される。つまり制御が反転している。
    // ここではコンストラクタを使ってサービスを注入しているため、「コンストラクタインジェクション」と呼ぶ
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function doSomething()
    {
        $this->service->doSomething();
    }


}

// 使われる側 サービス（ = dependency）
class Service
{
    public function doSomething()
    {
        // ...
    }

    // ...
}






