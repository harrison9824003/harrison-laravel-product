<?php

namespace Harrison\LaravelProduct\Exceptions;

use Harrison\LaravelProduct\Constants\Exceptions\Common\DataDuplicate;
use Throwable;

class DataDuplicateException extends ApiException
{
    public function __construct(
        private ?Throwable $throwable = null
    ) {
        parent::__construct(
            DataDuplicate::getCode(),
            DataDuplicate::getMessage(),
            [],
            $throwable
        );
    }
}
