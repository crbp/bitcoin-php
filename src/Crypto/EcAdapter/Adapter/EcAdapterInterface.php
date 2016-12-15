<?php

namespace BitWaspNew\Bitcoin\Crypto\EcAdapter\Adapter;

use BitWaspNew\Bitcoin\Crypto\Random\RbgInterface;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\Key\PrivateKeyInterface;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\Key\PublicKeyInterface;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\Signature\CompactSignatureInterface;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\Signature\SignatureInterface;
use BitWaspNew\Buffertools\BufferInterface;

interface EcAdapterInterface
{
    /**
     * @return \BitWasp\Bitcoin\Math\Math
     */
    public function getMath();

    /**
     * @return \Mdanter\Ecc\Primitives\GeneratorPoint
     */
    public function getGenerator();

    /**
     * @param BufferInterface $buffer
     * @return bool
     */
    public function validatePrivateKey(BufferInterface $buffer);

    /**
     * @param \GMP $element
     * @param bool|false $halfOrder
     * @return bool
     */
    public function validateSignatureElement(\GMP $element, $halfOrder = false);

    /**
     * @param \GMP $scalar
     * @param bool|false $compressed
     * @return PrivateKeyInterface
     */
    public function getPrivateKey(\GMP $scalar, $compressed = false);

    /**
     * @param BufferInterface $messageHash
     * @param PrivateKeyInterface $privateKey
     * @param RbgInterface $rbg
     * @return SignatureInterface
     */
    public function sign(BufferInterface $messageHash, PrivateKeyInterface $privateKey, RbgInterface $rbg = null);

    /**
     * @param PublicKeyInterface $publicKey
     * @param SignatureInterface $signature
     * @param BufferInterface $messageHash
     * @return bool
     */
    public function verify(BufferInterface $messageHash, PublicKeyInterface $publicKey, SignatureInterface $signature);

    /**
     * @param PrivateKeyInterface $privateKey
     * @param BufferInterface $messageHash
     * @param RbgInterface $rbg
     * @return CompactSignatureInterface
     */
    public function signCompact(BufferInterface $messageHash, PrivateKeyInterface $privateKey, RbgInterface $rbg = null);

    /**
     * @param BufferInterface $messageHash
     * @param CompactSignatureInterface $compactSignature
     * @return PublicKeyInterface
     */
    public function recover(BufferInterface $messageHash, CompactSignatureInterface $compactSignature);
}
