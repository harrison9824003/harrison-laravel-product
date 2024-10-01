<?php

namespace Harrison\LaravelProduct\Requests\Common;

use Harrison\LaravelProduct\Models\ValueObjects\Product\PageCondition;
use Harrison\LaravelProduct\Requests\ApiRequest;

class PageRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'perPage' => 'nullable|integer|lte:total',
            'currentPage' => 'nullable|integer|lte:lastPage',
            'total' => 'nullable|integer',
            'lastPage' => 'nullable|integer',
        ];
    }

    public function messages()
    {
        return [
            'perPage.integer' => '每頁筆數須為數字',
            'currentPage.integer' => '當前頁數須為數字',
            'total.integer' => '總筆數須為數字',
            'lastPage.integer' => '總頁數須為數字',
            'perPage.lte' => '每頁筆數須小於等於總筆數',
            'currentPage.lte' => '當前頁數須小於等於總頁數',
        ];
    }

    /**
     * 取回每頁顯示筆數
     */
    public function getPerPage(): int
    {
        return $this->input('perPage', 10);
    }

    /**
     * 取回當前頁數
     */
    public function getCurrentPage(): int
    {
        return $this->input('currentPage', 1);
    }

    /**
     * 取回頁面基本資訊物件
     */
    public function getPageCondition(): PageCondition
    {
        return new PageCondition(
            $this->getCurrentPage(),
            $this->getPerPage()
        );
    }
}
