<?php

namespace BitWaspNew\Bitcoin\Transaction;

use BitWaspNew\Bitcoin\Serializer\Transaction\TransactionSerializer;
use BitWaspNew\Bitcoin\Transaction\Factory\TxBuilder;
use BitWaspNew\Bitcoin\Transaction\Mutator\TxMutator;

class TransactionFactory
{
    /**
     * @return TxBuilder
     */
    public static function build()
    {
        return new TxBuilder();
    }

    /**
     * @param TransactionInterface $transaction
     * @return TxMutator
     */
    public static function mutate(TransactionInterface $transaction)
    {
        return new TxMutator($transaction);
    }

    /**
     * @param \BitWasp\Buffertools\BufferInterface|string $string
     * @return Transaction
     */
    public static function fromHex($string)
    {
        return (new TransactionSerializer())->parse($string);
    }
}
