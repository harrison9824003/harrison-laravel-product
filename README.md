# 商品套件

## 1. 商品資料

class `Harrison\LaravelProduct\Controllers\ProductController`

功能描述：提供 API 管理商品資料管理增刪修查找

## 2. 規格資料

class `Harrison\LaravelProduct\Controllers\SpecCategoryController`

功能描述：提供 API 管理規格資料管理增刪修查找

## 3. Provider

class `Harrison\LaravelProduct\Providers\HarrisonLaravelProductProvider`

功能描述：

1. 初始化載入模板、migration、config、route
2. `singleton` 每個 model，建立 model id 到物件，id 提供給全站判斷是哪一種資料類型

