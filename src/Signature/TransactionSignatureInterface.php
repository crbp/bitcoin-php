<?php

namespace BitWaspNew\Bitcoin\Signature;

use BitWaspNew\Bitcoin\Crypto\EcAdapter\Signature\SignatureInterface;
use BitWaspNew\Bitcoin\SerializableInterface;

interface TransactionSignatureInterface extends SerializableInterface
{
    /**
     * @return SignatureInterface
     */
    public function getSignature();

    /**
     * @return int|string
     */
    public function getHashType();
}
