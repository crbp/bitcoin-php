<?php

namespace BitWaspNew\Bitcoin\Signature;

use BitWasp\Buffertools\BufferInterface;

interface SignatureSortInterface
{
    /**
     * @param \BitWaspNew\Bitcoin\Crypto\EcAdapter\Signature\SignatureInterface[] $signatures
     * @param \BitWaspNew\Bitcoin\Crypto\EcAdapter\Key\PublicKeyInterface[] $publicKeys
     * @param BufferInterface $messageHash
     * @return \SplObjectStorage
     */
    public function link(array $signatures, array $publicKeys, BufferInterface $messageHash);
}
