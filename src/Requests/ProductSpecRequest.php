<?php

namespace Harrison\LaravelProduct\Requests;

use Illuminate\Validation\Rule;

class ProductSpecRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                Rule::unique('pj_spec_category')->ignore($this->route('spec')),
                'max:255'
            ],
            'parent_id' => 'nullable|integer',
        ];
    }

    public function messages()
    {
        return [
            'name.max' => '名稱最大字數為 255 字元',
            'parent_id.integer' => 'parent_id 必須為數字'
        ];
    }

    /**
     * 取回名稱
     */
    public function getName(): string
    {
        return $this->input('name');
    }

    /**
     * 取回父類別編號
     */
    public function getParentId(): int
    {
        return $this->input('parent_id', 0);
    }
}