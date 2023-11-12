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
}