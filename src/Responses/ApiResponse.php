<?php

namespace Harrison\LaravelProduct\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse extends JsonResponse
{
    public function __construct(
        mixed $data = null,
        mixed $metadata = null,
        int $statusCode = 200
    ) {
        parent::__construct([
            "data" => $data,
            "metadata" => $metadata,

        ], $statusCode);
    }
}
