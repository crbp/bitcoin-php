<?php

namespace BitWaspNew\Bitcoin\Transaction;

use BitWaspNew\Bitcoin\SerializableInterface;
use BitWaspNew\Buffertools\BufferInterface;

interface OutPointInterface extends SerializableInterface
{
    /**
     * @return BufferInterface
     */
    public function getTxId();

    /**
     * @return int
     */
    public function getVout();

    /**
     * @param OutPointInterface $outPoint
     * @return bool
     */
    public function equals(OutPointInterface $outPoint);
}
