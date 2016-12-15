<?php

namespace BitWaspNew\Bitcoin\Transaction;

use BitWaspNew\Bitcoin\Script\ScriptInterface;
use BitWaspNew\Bitcoin\Serializable;
use BitWaspNew\Bitcoin\Serializer\Transaction\TransactionOutputSerializer;

class TransactionOutput extends Serializable implements TransactionOutputInterface
{

    /**
     * @var string|int
     */
    private $value;

    /**
     * @var ScriptInterface
     */
    private $script;

    /**
     * Initialize class
     *
     * @param int $value
     * @param ScriptInterface $script
     */
    public function __construct($value, ScriptInterface $script)
    {
        $this->value = $value;
        $this->script = $script;
    }

    /**
     * @see TransactionOutputInterface::getValue()
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @see TransactionOutputInterface::getScript()
     */
    public function getScript()
    {
        return $this->script;
    }

    /**
     * @param TransactionOutputInterface $output
     * @return bool
     */
    public function equals(TransactionOutputInterface $output)
    {
        $script = $this->script->equals($output->getScript());
        if (!$script) {
            return false;
        }

        return gmp_cmp($this->value, $output->getValue()) === 0;
    }

    /**
     * @see \BitWaspNew\Bitcoin\SerializableInterface::getBuffer()
     */
    public function getBuffer()
    {
        return (new TransactionOutputSerializer())->serialize($this);
    }
}
