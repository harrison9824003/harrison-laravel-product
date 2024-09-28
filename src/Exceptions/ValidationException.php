<?php

namespace Harrison\LaravelProduct\Exceptions;

use Harrison\LaravelProduct\Constants\Exceptions\Common\Validation;
use Illuminate\Contracts\Validation\Validator;
use Throwable;

class ValidationException extends ApiException
{
    public function __construct(
        private Validator $validator,
        private ?Throwable $throwable = null
    ) {
        parent::__construct(
            Validation::getCode(),
            Validation::getMessage(),
            $validator->errors()->getMessages(),
            $throwable
        );
    }
}
