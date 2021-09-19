<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class TestCsvController extends Controller
{
    // CSVの１行目のヘッダー（項目名）
    protected $head;

    // 書き込みを行うための、新しく作成するCSVファイル
    protected $csvFilePath;

    public function __construct()
    {
        // 指定しているヘッダ項目を取得して、プロパティにセットする
        $this->head = $this->getHead();
    }

    public function index()
    {
        // DB:beginTransaction();

        // ファイルの読み込み  SplFileObjectのインスタンスを作成する
        // SplFileObjectクラスで読み込むことでループさせる際に１行ずつデータを取り出せるようにできる
        $file = new \SplFileObject(storage_path('app/public/kinki.csv'));

        // pr(storage_path('app/public/kinki.csv'));  //  /var/www/html/storage/app/public/kinki.csv

        $file->setFlags(
            // laravelのクラスではなくPHP固有のクラスを使うときは前にバックスラッシュをつける必要がある
            \SplFileObject::READ_CSV |          // CSV 列として行を読み込む
            \SplFileObject::READ_AHEAD |        // 先読み/巻き戻しで読み出す。
            \SplFileObject::SKIP_EMPTY |        // 空行は読み飛ばす
            \SplFileObject::DROP_NEW_LINE       // 行末の改行を読み飛ばす
        );

        // 書き込み用 CSVファイルの作成 （作成されたcsvファイルのパスが代入される）
        $this->csvFilePath = $this->createCsvFile();   //  /var/www/html/storage/app/result_210911_035531.csv

        // 読み込んだCSVデータをループ
        $i = 0;

        // $file にはCSV(kinki.csv) の全行のデータが配列で保存されている
        // $line にはCSV(kinki.csv) の１行ごとのデータが配列で保存されている
        foreach ($file as $line) {
            // 以下のコード時点では、ヘッダーの項目名が文字化けをしている(日本語部分が文字化け)
            // pr($line, '$line',1,1);if($i == 10){exit;};

            // pr(mb_detect_encoding($line[7]),1,1);

            // 以下で、文字コードを変換することで日本語の文字化けが解消される (UTF-8へ変換する)
            mb_convert_variables('UTF-8', 'SJIS-win', $line);
            // pr($line, '$line',1,1);
            // pr($line, '$line',1);if($i == 10){exit;};

            // pr(mb_detect_encoding($line[7]),1,1);

            // 文字コードをUTF-8へ変換
            if ($i == 0 && !$this->checkHeaders($line)) {
                // ここにヘッダーチェックエラー時の処理
                // フォームからのアップロードっであればヘッダーチェックは、リクエストクラスで実装するのがおすすめ
                throw new Exception('CSVのヘッダーが合致しません');
            }

            // コピーもととなるCSV（kinki.csv）の１行分（$line）を、新しく作ったCSVファイルへ書き込み追加する
            $this->writeCsv($line);
            $i++;

            if ($i == 0) {
                exit;
            }
        }






        // exit;

    }


    /**
     * CSVファイルを作成しファイルパスを返却する
     *
     * @return string
     */
    private function createCsvFile()
    {
        // ファイル名とファイルパスを定義する
        $csvFilePath = storage_path(sprintf('app/result_%s.csv', date('Y_m_d_His')));  //   /var/www/html/storage/app/result_210911_040549.csv
        var_dump($csvFilePath, '$csvFilePath');

        // 文字コードをUTF-8からSJIS-winに変換する
        mb_convert_variables('SJIS-win', 'UTF-8', $csvFilePath);

        // 書き込みモードでファイルを開きつつ、ファイルがなければディレクトリにファイルを作成する (この時点でディレクトリにファイルが作成される)
        $res = fopen($csvFilePath, 'w');

        // 正しくファイルに書き込めるかのチェック
        if ($res === false) {
            throw new Exception('ファイルの書き込みに失敗しました');
        }

        // 開いているファイルを閉じる
        fclose($res);

        return $csvFilePath;
    }


    /**
     * ヘッダー項目が合致しているかを返却する
     *
     * @param $array
     * @return bool
     */
    private function checkHeaders($array)
    {
        return ($this->head == $array);
    }



    /**
     * CSVファイルに書き出す
     *
     * @param array $line １行分のデータが入った配列
     */
    private function writeCsv($line)
    {
        // 作った新規のCSVファイルを、書き出しのみでファイルを開く
        $res = fopen($this->csvFilePath, 'a');
        // pr($line, 1,1);

        // 文字コードを変換 (SJIS-win に変換する)
        mb_convert_variables('SJIS-win', 'UTF-8', $line);

        // 引数で渡ってきた配列のデータを、新規で作成したcsvファイル()に、書き出す（追加する）
        fputcsv($res, $line);

        fclose($res);
    }


    /**
     * ヘッダー項目を返す
     *
     * @return array
     */
    private function getHead()
    {
        $head = [
            "住所CD",
            "都道府県CD",
            "市区町村CD",
            "町域CD",
            "郵便番号",
            "事業所フラグ",
            "廃止フラグ",
            "都道府県",
            "都道府県カナ",
            "市区町村",
            "市区町村カナ",
            "町域",
            "町域カナ",
            "町域補足",
            "京都通り名",
            "字丁目",
            "字丁目カナ",
            "補足",
            "事業所名",
            "事業所名カナ",
            "事業所住所",
            "新住所CD",
        ];

        return $head;
    }


}
