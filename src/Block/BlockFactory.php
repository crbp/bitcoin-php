<?php

namespace BitWaspNew\Bitcoin\Block;

use BitWaspNew\Bitcoin\Bitcoin;
use BitWaspNew\Bitcoin\Math\Math;
use BitWaspNew\Bitcoin\Serializer\Block\BlockHeaderSerializer;
use BitWaspNew\Bitcoin\Serializer\Block\BlockSerializer;
use BitWaspNew\Bitcoin\Serializer\Transaction\TransactionSerializer;

class BlockFactory
{
    /**
     * @param \BitWasp\Buffertools\BufferInterface|string $string
     * @param Math $math
     * @return BlockInterface
     */
    public static function fromHex($string, Math $math = null)
    {
        return (new BlockSerializer(
            $math ?: Bitcoin::getMath(),
            new BlockHeaderSerializer(),
            new TransactionSerializer()
        ))
            ->parse($string);
    }
}
