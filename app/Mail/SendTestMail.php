<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendTestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // HTMLメールを送信する
        // return $this->view('emails.test')
        //             ->from('test@gmail.com', 'Test花子')
        //             ->subject('これはMailableクラスを利用したメールテストです');

        // テストのための変数
        $user_name = 'テスト太郎';
        $user_email = 'test@aaa.com';

        // 添付ファイルテスト
        // $file_path_1 = 'app/public/20210810-145015-1.jpg';
        // $file_path_2 = 'app/public/20210810-145015-2.jpg';


        // textメールを送信する
        $mail = $this->text('emails.test_text')                                         // どのviewテンプレートを使用するかの設定
            ->from('test@gmail.com', '山本太郎')                                // 送り主
            ->subject('これはMailableクラスを利用した、テキストメールのテストです')   // メール件名
            // ->cc('') // CC
            // ->bcc('') //bcc
            ->with(compact('user_name', 'user_email')); // viewに変数を渡す
            // ->attach(storage_path($file_path_1))       // ファイルを添付
            // ->attach(storage_path($file_path_2));      // 複数ファイルを添付


        // 複数ファイル
        $files = [
            storage_path('app/public/20210810-145015-1.jpg'),
            storage_path('app/public/20210811-152554-1.jpg'),
        ];

        // ファイルを複数添付する
        foreach ($files as $file) {
            $mail->attach($file);
        };

        return $mail;
    }
}
