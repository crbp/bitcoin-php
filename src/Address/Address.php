<?php

namespace BitWaspNew\Bitcoin\Address;

use BitWaspNew\Bitcoin\Base58;
use BitWaspNew\Bitcoin\Bitcoin;
use BitWaspNew\Buffertools\Buffer;
use BitWaspNew\Bitcoin\Network\NetworkInterface;
use BitWaspNew\Buffertools\BufferInterface;

/**
 * Abstract Class Address
 * Used to store a hash, and a base58 encoded address
 */
abstract class Address implements AddressInterface
{
    /**
     * @var BufferInterface
     */
    private $hash;

    /**
     * @param BufferInterface $hash
     */
    public function __construct(BufferInterface $hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return BufferInterface
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param NetworkInterface|null $network
     * @return string
     */
    public function getAddress(NetworkInterface $network = null)
    {
        $network = $network ?: Bitcoin::getNetwork();
        $payload = new Buffer($this->getPrefixByte($network) . $this->getHash()->getBinary());
        return Base58::encodeCheck($payload);
    }
}
