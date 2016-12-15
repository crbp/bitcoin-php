<?php

namespace BitWaspNew\Bitcoin\Transaction\SignatureHash;

use BitWaspNew\Bitcoin\Script\ScriptInterface;
use BitWaspNew\Bitcoin\Transaction\TransactionInterface;

abstract class SigHash implements SigHashInterface
{
    const V0 = 0;
    const V1 = 1;
    
    /**
     * @var TransactionInterface
     */
    protected $tx;

    /**
     * SigHash constructor.
     * @param TransactionInterface $transaction
     */
    public function __construct(TransactionInterface $transaction)
    {
        $this->tx = $transaction;
    }

    abstract public function calculate(ScriptInterface $txOutScript, $inputToSign, $sighashType = SigHash::ALL);
}
