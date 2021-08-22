<?php

namespace App\Library;

class Validate
{
    // 許可する画像のデフォルト拡張子
	public const DEFAULT_EXTENSION_IMG = [
		'jpg',
		'jpeg',
		'png',
		'gif'
	];

    // 許可する画像のデフォルトMIMEタイプ
	public const DEFAULT_MIME_IMG = [
		'image/jpeg',
		'image/png',
		'image/gif'
    ];

	// 許可する画像のデフォルト最大サイズ（10Mまで）
    public const DEFAULT_MAX_SIZE_IMG = 1024 * 1024 * 10;

	/**
	 * checkImage
	 * アップロードされた画像の妥当性をチェックする
	 *
	 * @param  object $file 		      アップロード情報(name,type,tmp_name,error等)を取得できるコレクションクラス(オブジェクト)を渡す
	 * @param  array  $allowed_extension  許可する拡張子を配列で指定（nullの場合デフォルト設定が適応）
	 * @param  array  $allowed_mime       許可するMIMEタイプを配列で指定（nullの場合デフォルト設定が適応）
	 * @param  int    $allowed_size    	  許可する最大ファイルサイズを指定（nullの場合デフォルト設定が適応）
	 * @return array              		  チェックOK：[true, null]		チェックNG：[false, エラーメッセージ]
	 */
    public static function checkImage($file, array $allowed_extension = null, array $allowed_mime = null, $allowed_size = null)
    {
        // デフォルト設定を使用
		if (!$allowed_extension) {
			$allowed_extension = self::DEFAULT_EXTENSION_IMG;
		}
		if (!$allowed_mime) {
			$allowed_mime	   = self::DEFAULT_MIME_IMG;
		}
		if (!$allowed_size) {
			$allowed_size 	   = self::DEFAULT_MAX_SIZE_IMG;
        }

		// PHPによるエラーを確認する
		if ($file->getError() !== UPLOAD_ERR_OK) {
			return [false, 'アップロードエラーを検出しました'];
        }

		// ファイル名から拡張子をチェックする
		if (!in_array(self::getExtension($file->getClientOriginalName()), $allowed_extension)) {
			return [false, '画像ファイルのみアップロード可能です'];
        }

		// ファイルの中身を見てMIMEタイプをチェックする
		$mime_type = $file->getMimeType();
		if (!in_array($mime_type, $allowed_mime)) {
			return [false, '不正な画像ファイル形式です'];
        }

		// ファイルサイズをチェックする
		if ($file->getSize() > $allowed_size) {
			return [false, 'ファイルサイズがオーバーしています'];
        }

		return [true, null];
    }

	/**
	 * getExtension
	 * ファイル名を元に拡張子を返す
     *
	 * @param  string $file_name 拡張子を取得したいファイル名 	例) hello.jpg
	 * @return string ドットを含まない拡張子  					例) jpg
	 */
    public static function getExtension($file_name)
    {
		return pathinfo($file_name, PATHINFO_EXTENSION);
    }



}
