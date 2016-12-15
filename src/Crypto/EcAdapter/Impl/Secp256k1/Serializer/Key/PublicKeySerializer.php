<?php

namespace BitWaspNew\Bitcoin\Crypto\EcAdapter\Impl\Secp256k1\Serializer\Key;

use BitWaspNew\Bitcoin\Crypto\EcAdapter\Impl\Secp256k1\Adapter\EcAdapter;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\Impl\Secp256k1\Key\PublicKey;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\Serializer\Key\PublicKeySerializerInterface;
use BitWaspNew\Buffertools\Buffer;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\Key\PublicKeyInterface;
use BitWaspNew\Buffertools\BufferInterface;
use BitWaspNew\Buffertools\Parser;

class PublicKeySerializer implements PublicKeySerializerInterface
{
    /**
     * @var EcAdapter
     */
    private $ecAdapter;

    /**
     * @param EcAdapter $ecAdapter
     */
    public function __construct(EcAdapter $ecAdapter)
    {
        $this->ecAdapter = $ecAdapter;
    }

    /**
     * @param PublicKey $publicKey
     * @return BufferInterface
     */
    private function doSerialize(PublicKey $publicKey)
    {
        $serialized = '';
        $isCompressed = $publicKey->isCompressed();
        if (!secp256k1_ec_pubkey_serialize(
            $this->ecAdapter->getContext(),
            $serialized,
            $publicKey->getResource(),
            $isCompressed
        )) {
            throw new \RuntimeException('Secp256k1: Failed to serialize public key');
        }

        return new Buffer(
            $serialized,
            $isCompressed ? PublicKey::LENGTH_COMPRESSED : PublicKey::LENGTH_UNCOMPRESSED,
            $this->ecAdapter->getMath()
        );
    }

    /**
     * @param PublicKeyInterface $publicKey
     * @return BufferInterface
     */
    public function serialize(PublicKeyInterface $publicKey)
    {
        /** @var PublicKey $publicKey */
        return $this->doSerialize($publicKey);
    }

    /**
     * @param \BitWasp\Buffertools\BufferInterface|string $data
     * @return PublicKey
     */
    public function parse($data)
    {
        $buffer = (new Parser($data))->getBuffer();
        $binary = $buffer->getBinary();
        $pubkey_t = '';
        /** @var resource $pubkey_t */
        if (!secp256k1_ec_pubkey_parse($this->ecAdapter->getContext(), $pubkey_t, $binary)) {
            throw new \RuntimeException('Secp256k1 failed to parse public key');
        }

        return new PublicKey(
            $this->ecAdapter,
            $pubkey_t,
            $buffer->getSize() === 33
        );
    }
}
