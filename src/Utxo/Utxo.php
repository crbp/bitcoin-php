<?php

namespace BitWaspNew\Bitcoin\Utxo;

use BitWaspNew\Bitcoin\Transaction\OutPoint;
use BitWaspNew\Bitcoin\Transaction\OutPointInterface;
use BitWaspNew\Bitcoin\Transaction\TransactionOutputInterface;

class Utxo implements UtxoInterface
{
    /**
     * @var OutPointInterface
     */
    private $outPoint;

    /**
     * @var TransactionOutputInterface
     */
    private $prevOut;

    /**
     * @param OutPointInterface $outPoint
     * @param TransactionOutputInterface $prevOut
     */
    public function __construct(OutPointInterface $outPoint, TransactionOutputInterface $prevOut)
    {
        $this->outPoint = $outPoint;
        $this->prevOut = $prevOut;
    }

    /**
     * @return OutPoint
     */
    public function getOutPoint()
    {
        return $this->outPoint;
    }

    /**
     * @return TransactionOutputInterface
     */
    public function getOutput()
    {
        return $this->prevOut;
    }
}
