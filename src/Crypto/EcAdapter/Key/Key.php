<?php

namespace BitWaspNew\Bitcoin\Crypto\EcAdapter\Key;

use BitWaspNew\Bitcoin\Address\AddressFactory;
use BitWaspNew\Bitcoin\Crypto\Hash;
use BitWaspNew\Bitcoin\Serializable;

abstract class Key extends Serializable implements KeyInterface
{
    /**
     * @return bool
     */
    public function isPrivate()
    {
        return $this instanceof PrivateKeyInterface;
    }

    /**
     * @return \BitWasp\Buffertools\BufferInterface
     */
    public function getPubKeyHash()
    {
        if ($this instanceof PrivateKeyInterface) {
            $publicKey = $this->getPublicKey();
        } else {
            $publicKey = $this;
        }

        return Hash::sha256ripe160($publicKey->getBuffer());
    }

    /**
     * @return \BitWasp\Bitcoin\Address\PayToPubKeyHashAddress
     */
    public function getAddress()
    {
        return AddressFactory::fromKey($this);
    }
}
