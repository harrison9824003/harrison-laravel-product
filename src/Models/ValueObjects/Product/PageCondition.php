<?php

namespace Harrison\LaravelProduct\Models\ValueObjects\Product;

class PageCondition
{
    public function __construct(
        private int $page,
        private int $limit
    ) {
    }

    public function getValue(string $column): mixed
    {
        return $this->{$column};
    }
}
