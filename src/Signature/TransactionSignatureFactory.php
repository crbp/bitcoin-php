<?php

namespace BitWaspNew\Bitcoin\Signature;

use BitWaspNew\Bitcoin\Crypto\EcAdapter\Adapter\EcAdapterInterface;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\EcSerializer;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\Serializer\Signature\DerSignatureSerializerInterface;
use BitWaspNew\Bitcoin\Serializer\Signature\TransactionSignatureSerializer;

class TransactionSignatureFactory
{
    /**
     * @param \BitWasp\Buffertools\BufferInterface|string $string
     * @param EcAdapterInterface $ecAdapter
     * @return TransactionSignatureInterface
     */
    public static function fromHex($string, EcAdapterInterface $ecAdapter = null)
    {
        $serializer = new TransactionSignatureSerializer(
            EcSerializer::getSerializer(DerSignatureSerializerInterface::class, true, $ecAdapter)
        );

        return $serializer->parse($string);
    }
}
