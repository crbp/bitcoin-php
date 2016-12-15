<?php

namespace BitWaspNew\Bitcoin\Serializer\Transaction;

use BitWaspNew\Bitcoin\Transaction\TransactionInterface;
use BitWaspNew\Buffertools\BufferInterface;
use BitWaspNew\Buffertools\Parser;

interface TransactionSerializerInterface
{
    /**
     * @param Parser $parser
     * @return TransactionInterface
     */
    public function fromParser(Parser $parser);

    /**
     * @param string|BufferInterface $data
     * @return TransactionInterface
     */
    public function parse($data);

    /**
     * @param TransactionInterface $transaction
     * @return BufferInterface
     */
    public function serialize(TransactionInterface $transaction);
}
