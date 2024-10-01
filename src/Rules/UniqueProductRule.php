<?php

namespace Harrison\LaravelProduct\Rules;

use Harrison\LaravelProduct\Models\Product;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueProductRule implements ValidationRule
{
    public function __construct(private ?string $productId)
    {
    }

    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        $count = Product::when($this->productId, function ($query) {
                return $query->where('id', '<>', $this->productId);
            })
            ->where($attribute, $value)
            ->count();

        if ($count) {
            $fail('The :attribute has already been taken.');
        }
    }
}
