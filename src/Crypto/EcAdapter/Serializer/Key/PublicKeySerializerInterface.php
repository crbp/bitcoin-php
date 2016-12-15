<?php

namespace BitWaspNew\Bitcoin\Crypto\EcAdapter\Serializer\Key;

use BitWaspNew\Bitcoin\Crypto\EcAdapter\Key\PublicKeyInterface;
use BitWasp\Buffertools\BufferInterface;

interface PublicKeySerializerInterface
{
    /**
     * @param PublicKeyInterface $publicKey
     * @return BufferInterface
     */
    public function serialize(PublicKeyInterface $publicKey);

    /**
     * @param string|BufferInterface $data
     * @return PublicKeyInterface
     */
    public function parse($data);
}
