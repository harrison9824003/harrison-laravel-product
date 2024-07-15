<?php

namespace Harrison\LaravelProduct\Exceptions;

use Harrison\LaravelProduct\Constants\Exceptions\Validation;
use Illuminate\Contracts\Validation\Validator;
use Throwable;

class ValidationException extends ApiException
{
    public function __construct(
        private Validator $validator,
        private string $errorCode = Validation::VALIDATION_FAIL_CODE,
        private string $errorMessage = Validation::VALIDATION_FAIL_MESSAGE,
        private ?Throwable $throwable = null
    ) {
        parent::__construct(
            $errorCode,
            $errorMessage,
            $validator->errors()->getMessages(),
            $throwable
        );
    }
}
