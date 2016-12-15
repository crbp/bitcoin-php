<?php

namespace BitWaspNew\Bitcoin\Utxo;

use BitWaspNew\Bitcoin\Transaction\OutPoint;
use BitWaspNew\Bitcoin\Transaction\TransactionOutputInterface;

interface UtxoInterface
{
    /**
     * @return OutPoint
     */
    public function getOutPoint();

    /**
     * @return TransactionOutputInterface
     */
    public function getOutput();
}
