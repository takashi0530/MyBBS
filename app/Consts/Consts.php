<?php

namespace App\Consts;

class Consts
{
    // 同時ファイルアップロード数
    const ALLOWED_FILE_UPLOAD_COUNT = 5;

    // 許可しているファイルアップロードサイズ
    const ALLOWED_FILE_UPLOAD_SIZE_10 = 1024 * 1024 * 10;

    const MIME_TYPE_JPEG = 'image/jpeg';
    const MIME_TYPE_PNG = 'image/png';
    const MIME_TYPE_GIF = 'image/gif';

    // 許可しているmimeタイプ
    const ALLOWED_MIME = [
        self::MIME_TYPE_JPEG,
        self::MIME_TYPE_PNG,
        self::MIME_TYPE_GIF,
    ];

}
