<?php

namespace Harrison\LaravelProduct\Constants\Exceptions;

/**
 * @property int code 錯誤代碼
 * @property string categoryName 錯誤功能名稱
 * @property string message 錯誤訊息
 * @method static int getCode() 取得錯誤代碼
 * @method static string getCategoryName() 取得錯誤功能名稱
 * @method static string getMessage() 取得錯誤訊息
 */
abstract class ExceptionContantAbstract
{
    public static int $code;

    public static string $categoryName;

    public static string $message;

    public static function getCode(): int
    {
        return static::$code;
    }

    public static function getCategoryName(): string
    {
        return static::$categoryName;
    }

    public static function getMessage(): string
    {
        return static::$message;
    }
}
