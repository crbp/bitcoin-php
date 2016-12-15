<?php

namespace BitWaspNew\Bitcoin\Transaction;

use BitWaspNew\Bitcoin\Script\ScriptInterface;
use BitWaspNew\Bitcoin\SerializableInterface;

interface TransactionOutputInterface extends SerializableInterface
{
    /**
     * Get the value of this output
     *
     * @return int|string
     */
    public function getValue();

    /**
     * Get the script for this output
     *
     * @return ScriptInterface
     */
    public function getScript();

    /**
     * @param TransactionOutputInterface $output
     * @return bool
     */
    public function equals(TransactionOutputInterface $output);
}
