<?php

namespace Harrison\LaravelProduct\Constants\Exceptions\Common;

use Harrison\LaravelProduct\Constants\Exceptions\ExceptionContantAbstract;

/**
 * request 驗證失敗
 * @property int code 錯誤代碼
 * @property string categoryName 錯誤功能名稱
 * @property string message 錯誤訊息
 */
class Validation extends ExceptionContantAbstract
{
    public static int $code = 1;

    public static string $message = 'request 驗證失敗';

    public static string $categoryName = 'Validation';
}
