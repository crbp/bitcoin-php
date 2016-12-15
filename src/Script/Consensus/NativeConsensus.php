<?php

namespace BitWaspNew\Bitcoin\Script\Consensus;

use BitWaspNew\Bitcoin\Bitcoin;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\Adapter\EcAdapterInterface;
use BitWaspNew\Bitcoin\Script\Interpreter\Checker;
use BitWaspNew\Bitcoin\Script\Interpreter\Interpreter;
use BitWaspNew\Bitcoin\Script\ScriptInterface;
use BitWaspNew\Bitcoin\Transaction\TransactionInterface;

class NativeConsensus implements ConsensusInterface
{
    /**
     * @var EcAdapterInterface
     */
    private $adapter;

    /**
     * NativeConsensus constructor.
     * @param EcAdapterInterface $ecAdapter
     */
    public function __construct(EcAdapterInterface $ecAdapter = null)
    {
        $this->adapter = $ecAdapter ?: Bitcoin::getEcAdapter();
    }

    /**
     * @param TransactionInterface $tx
     * @param ScriptInterface $scriptPubKey
     * @param int $nInputToSign
     * @param int $flags
     * @param int $amount
     * @return bool
     */
    public function verify(TransactionInterface $tx, ScriptInterface $scriptPubKey, $flags, $nInputToSign, $amount)
    {
        $inputs = $tx->getInputs();
        $interpreter = new Interpreter($this->adapter);
        return $interpreter->verify(
            $inputs[$nInputToSign]->getScript(),
            $scriptPubKey,
            $flags,
            new Checker($this->adapter, $tx, $nInputToSign, $amount),
            isset($tx->getWitnesses()[$nInputToSign]) ? $tx->getWitness($nInputToSign) : null
        );
    }
}
