<?php

namespace BitWaspNew\Bitcoin\Crypto\EcAdapter\Impl\Secp256k1\Signature;

interface SignatureInterface extends \BitWaspNew\Bitcoin\Crypto\EcAdapter\Signature\SignatureInterface
{
    /**
     * @return resource
     */
    public function getResource();
}
