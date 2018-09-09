<?php

namespace App\Adapter;

interface DomainTransactionInterface
{
    public function beginTransaction();

    public function commitTransaction();

    public function rollbackTransaction();
}