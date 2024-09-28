<?php

namespace Harrison\LaravelProduct\Services;

use Illuminate\Support\Facades\DB;

class DatabaseService
{
    /**
     * 建立指定 model transaction
     */
    public function createTransaction(mixed $callback)
    {
        return DB::transaction($callback);
    }

    /**
     * 建立指定 model commit
     */
    public function commit()
    {
        return DB::commit();
    }

    /**
     * 建立指定 model rollback
     */
    public function rollback()
    {
        return DB::rollBack();
    }
}