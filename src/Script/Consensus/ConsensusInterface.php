<?php

namespace BitWaspNew\Bitcoin\Script\Consensus;

use BitWaspNew\Bitcoin\Script\ScriptInterface;
use BitWaspNew\Bitcoin\Transaction\TransactionInterface;

interface ConsensusInterface
{
    /**
     * @param TransactionInterface $tx
     * @param ScriptInterface $scriptPubKey
     * @param integer $nInputToSign
     * @param int $flags
     * @param integer $amount
     * @return bool
     */
    public function verify(TransactionInterface $tx, ScriptInterface $scriptPubKey, $flags, $nInputToSign, $amount);
}
