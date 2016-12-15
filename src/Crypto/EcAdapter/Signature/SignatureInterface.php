<?php

namespace BitWaspNew\Bitcoin\Crypto\EcAdapter\Signature;

use BitWaspNew\Bitcoin\SerializableInterface;

interface SignatureInterface extends SerializableInterface, \Mdanter\Ecc\Crypto\Signature\SignatureInterface
{
    /**
     * @return bool
     */
    public function equals(SignatureInterface $signature);
}
