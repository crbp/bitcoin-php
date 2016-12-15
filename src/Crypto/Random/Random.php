<?php

namespace BitWaspNew\Bitcoin\Crypto\Random;

use BitWaspNew\Buffertools\Buffer;
use BitWaspNew\Bitcoin\Exceptions\RandomBytesFailure;

class Random implements RbgInterface
{
    /**
     * Return $length bytes. Throws an exception if
     * @param int $length
     * @return Buffer
     * @throws RandomBytesFailure
     */
    public function bytes($length = 32)
    {
        return new Buffer(random_bytes($length), $length);
    }
}
