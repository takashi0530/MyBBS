<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; // Storageライブラリを使用

class CsvController extends Controller
{
    // ヘッダーの項目名
    private const HEADER = [
        'id'         => '投稿ID',
        'title'      => '投稿タイトル',
        'body'       => '投稿内容',
        'created_at' => '投稿日',
        'updated_at' => '更新日'
    ];

    // 新規作成のCSVパス
    protected $csvFilePath;

    // 新規作成のCSVのファイル名
    protected $csvFileName;


    /**
     * index()
     *
     * 投稿された記事のCSVダウンロード
     */
    public function index()
    {
        // 記事を全件取得する
        $posts_data = DB::table('posts')->orderBy('id', 'asc')->get();

        // CSVの新規ファイルを作成し、パスをプロパティにセット
        $this->csvFilePath = $this->createCsvFIle();

        // パス情報からファイル名をプロパティにセット
        $this->csvFileName = basename($this->csvFilePath);

        // 取得した全ての投稿データを1行ずつ処理する
        foreach ($posts_data as $key => $line) {

            if ($key === 0) {
                // ヘッダーの書き込み
                $this->writeCsv(self::HEADER);
            }

            // 投稿内容を、新しく作成したカラのcsvファイルに書き込む
            $this->writeCsv($line);
        }

        // 作成したCSVファイルをダウンロードさせる  storage/app/csv/posts_2021_09_19_173431.csv
        return $this->downloadCsv();
    }


    /**
     * createCsvFile()
     *
     * CSVファイルを作成しファイルパスを返却する
     *
     * @return string $csvFilePath csvのファイルパス
     */
    private function createCsvFile(): string
    {
        // 新規作成するCSVのファイル名とファイルパスを定義する
        $csvFilePath = storage_path(sprintf('app/csv/posts_%s.csv', date('Y_m_d_His')));  ///var/www/html/storage/app/csv/posts_%s.csv

        // 文字コードをUTF-8からSJIS-winに変換する
        mb_convert_variables('SJIS-win', 'UTF-8', $csvFilePath);

        // 以下の処理の時点でディレクトリにカラのcsvファイルが生成される
        $result = fopen($csvFilePath, 'w');

        // 書き込み判定
        if ($result === false) {
            throw new \Exception('ファイルの書き込みに失敗しました');
        }

        // 開いているファイルを閉じる
        fclose($result);

        // ファイルパスを返却する
        return $csvFilePath;
    }


    /**
     * writeCsv()
     *
     * CSVファイルに書き出す
     *
     * @param array $line 1行分のデータが入った配列
     * @return void
     */
    private function writeCsv($line): void
    {
        // 作った新規のCSVファイルを書き出しのみでファイルを開く
        $res = fopen($this->csvFilePath, 'a');

        // stdClass のままだと処理ができないため、型を array に変換して再代入する
        $line = (array) $line;

        // 文字コードを変換（SJIS-win に変換する）
        mb_convert_variables('SJIS-win', 'UTF-8', $line);

        // 新規で作成したCSVファイルに（$res）、引数で渡ってきた配列のデータ($line)を書き出す（追加する）
        fputcsv($res, $line);

        fclose($res);
    }

    /**
     * downloadCsv
     *
     * 作成したCSVをダウンロードする
     *
     * @return object
     */
    private function downloadCsv(): object
    {
        $file_path = 'csv/' . $this->csvFileName;
        $file_name = $this->csvFileName;
        $mime_type = Storage::mimeType($file_path);
        $headers   = [['Content-Type' => $mime_type]];

        // ファイルをダウンロードする
        return Storage::download($file_path, $file_name, $headers);
    }


}
