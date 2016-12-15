<?php

namespace BitWaspNew\Bitcoin\Crypto\EcAdapter\Key;

use BitWaspNew\Bitcoin\Crypto\Random\RbgInterface;
use BitWaspNew\Bitcoin\Network\NetworkInterface;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\Signature\SignatureInterface;
use BitWaspNew\Buffertools\BufferInterface;

interface PrivateKeyInterface extends KeyInterface
{
    /**
     * Return the decimal secret multiplier
     *
     * @return \GMP
     */
    public function getSecret();

    /**
     * @param BufferInterface $msg32
     * @param RbgInterface $rbg
     * @return SignatureInterface
     */
    public function sign(BufferInterface $msg32, RbgInterface $rbg = null);

    /**
     * Return the public key.
     *
     * @return PublicKeyInterface
     */
    public function getPublicKey();

    /**
     * Convert the private key to wallet import format. This function
     * optionally takes a NetworkInterface for exporting keys for other networks.
     *
     * @param NetworkInterface $network
     * @return string
     */
    public function toWif(NetworkInterface $network = null);
}
