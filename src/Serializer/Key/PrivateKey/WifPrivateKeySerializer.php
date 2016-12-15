<?php

namespace BitWaspNew\Bitcoin\Serializer\Key\PrivateKey;

use BitWaspNew\Bitcoin\Base58;
use BitWaspNew\Bitcoin\Bitcoin;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\Serializer\Key\PrivateKeySerializerInterface;
use BitWaspNew\Bitcoin\Key\PrivateKeyFactory;
use BitWaspNew\Buffertools\Buffer;
use BitWaspNew\Bitcoin\Exceptions\InvalidPrivateKey;
use BitWaspNew\Bitcoin\Exceptions\Base58ChecksumFailure;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\Key\PrivateKeyInterface;
use BitWaspNew\Bitcoin\Math\Math;
use BitWaspNew\Bitcoin\Network\NetworkInterface;
use BitWaspNew\Buffertools\Buffertools;

class WifPrivateKeySerializer
{
    /**
     * @var Math
     */
    private $math;

    /**
     * @var PrivateKeySerializerInterface
     */
    private $keySerializer;

    /**
     * @param Math $math
     * @param PrivateKeySerializerInterface $hexSerializer
     */
    public function __construct(Math $math, PrivateKeySerializerInterface $hexSerializer)
    {
        $this->math = $math;
        $this->keySerializer = $hexSerializer;
    }

    /**
     * @param NetworkInterface $network
     * @param PrivateKeyInterface $privateKey
     * @return string
     */
    public function serialize(NetworkInterface $network, PrivateKeyInterface $privateKey)
    {
        $serialized = Buffertools::concat(
            Buffer::hex($network->getPrivByte()),
            $this->keySerializer->serialize($privateKey)
        );

        if ($privateKey->isCompressed()) {
            $serialized = Buffertools::concat(
                $serialized,
                new Buffer("\x01", 1)
            );
        }

        return Base58::encodeCheck($serialized);
    }

    /**
     * @param string $wif
     * @param NetworkInterface|null $network
     * @return \BitWasp\Bitcoin\Crypto\EcAdapter\Impl\PhpEcc\Key\PrivateKey
     * @throws Base58ChecksumFailure
     * @throws InvalidPrivateKey
     */
    public function parse($wif, NetworkInterface $network = null)
    {
        $network = $network ?: Bitcoin::getNetwork();
        $data = Base58::decodeCheck($wif);
        if ($data->slice(0, 1)->getHex() !== $network->getPrivByte()) {
            throw new \RuntimeException('WIF prefix does not match networks');
        }

        $payload = $data->slice(1);
        $size = $payload->getSize();

        if (33 === $size) {
            $compressed = true;
            $payload = $payload->slice(0, 32);
        } else if (32 === $size) {
            $compressed = false;
        } else {
            throw new InvalidPrivateKey("Private key should be always be 32 or 33 bytes (depending on if it's compressed)");
        }

        return PrivateKeyFactory::fromInt($payload->getInt(), $compressed);
    }
}
