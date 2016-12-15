<?php

namespace BitWaspNew\Bitcoin\Signature;

use BitWaspNew\Bitcoin\Crypto\EcAdapter\Adapter\EcAdapterInterface;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\Signature\SignatureInterface;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\EcSerializer;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\Serializer\Signature\DerSignatureSerializerInterface;

class SignatureFactory
{

    /**
     * @param \BitWasp\Buffertools\BufferInterface|string $string
     * @param EcAdapterInterface $ecAdapter
     * @return SignatureInterface
     */
    public static function fromHex($string, EcAdapterInterface $ecAdapter = null)
    {
        /** @var DerSignatureSerializerInterface $serializer */
        $serializer = EcSerializer::getSerializer(DerSignatureSerializerInterface::class, true, $ecAdapter);
        return $serializer->parse($string);
    }
}
