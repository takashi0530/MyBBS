<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Mailファサードを利用する
use Illuminate\Support\Facades\Mail;

// SendTestMailクラスを使用する
use App\Mail\SendTestMail;

class MailSendController extends Controller
{
    // Mailファサードを使用したメール送信
    public function index() {
        $data = [];

        Mail::send('emails.test', $data, function($message) {
            $message->to('hello@example.com', 'テスト')
                ->from('apple@apple.com')
                ->subject('これはlaravelのテストメールです');
        });
    }

    // Mailableクラスを使用したメール送信
    public function send() {

        $to = [
            [
                'email' => 'test@gmail.com',
                'name' => 'Testですよ'
            ],
            // 複数人に送信する場合
            [
                'email' => 'test2@xxx.com',
                'name' => '複数人に送信するTestですよ'
            ]
        ];

        Mail::to($to)->send(new SendTestMail());

    }
}
