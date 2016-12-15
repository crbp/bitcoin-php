<?php

namespace BitWaspNew\Bitcoin\Transaction\Factory;

use BitWaspNew\Bitcoin\Script\ScriptInterface;
use BitWaspNew\Bitcoin\Script\ScriptWitnessInterface;

class SigValues
{
    /**
     * @var ScriptInterface
     */
    private $scriptSig;

    /**
     * @var ScriptWitnessInterface
     */
    private $scriptWitness;

    /**
     * SigValues constructor.
     * @param ScriptInterface $scriptSig
     * @param ScriptWitnessInterface $scriptWitness
     */
    public function __construct(ScriptInterface $scriptSig, ScriptWitnessInterface $scriptWitness)
    {
        $this->scriptSig = $scriptSig;
        $this->scriptWitness = $scriptWitness;
    }

    /**
     * @return ScriptInterface
     */
    public function getScriptSig()
    {
        return $this->scriptSig;
    }

    /**
     * @return ScriptWitnessInterface
     */
    public function getScriptWitness()
    {
        return $this->scriptWitness;
    }
}
