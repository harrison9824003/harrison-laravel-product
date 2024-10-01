<?php

namespace Harrison\LaravelProduct\Constants\Exceptions\Common;

use Harrison\LaravelProduct\Constants\Exceptions\ExceptionContantAbstract;

/**
 * 資料重複
 *
 * @property int code 錯誤代碼
 * @property string categoryName 錯誤功能名稱
 * @property string message 錯誤訊息
 */
class DataDuplicate extends ExceptionContantAbstract
{
    public static int $code = 3;

    public static string $message = '資料重複';

    public static string $categoryName = 'DataDuplicate';
}
