<?php

namespace Harrison\LaravelProduct\Services\Traits;

use Illuminate\Support\Facades\DB;

trait DatabaseService
{
    /**
     * 建立指定 connection begin transaction
     */
    public function beginTransaction()
    {
        return DB::connection('harrison_laravel_product')->beginTransaction();
    }

    /**
     * 建立指定 connection transaction commit
     */
    public function commit()
    {
        return DB::connection('harrison_laravel_product')->commit();
    }

    /**
     * 建立指定 connection transaction rollback
     */
    public function rollback()
    {
        return DB::connection('harrison_laravel_product')->rollBack();
    }
}
