<?php

namespace Harrison\LaravelProduct\Constants\Exceptions\Common;

use Harrison\LaravelProduct\Constants\Exceptions\ExceptionContantAbstract;

/**
 * 找不到資源
 * @property int code 錯誤代碼
 * @property string categoryName 錯誤功能名稱
 * @property string message 錯誤訊息
 */
class NotFound extends ExceptionContantAbstract
{
    public static int $code = 2;

    public static string $message = '找不到資源';

    public static string $categoryName = 'NotFound';
}
