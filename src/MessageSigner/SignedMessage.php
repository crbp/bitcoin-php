<?php

namespace BitWaspNew\Bitcoin\MessageSigner;

use BitWaspNew\Bitcoin\Crypto\EcAdapter\EcSerializer;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\Serializer\Signature\CompactSignatureSerializerInterface;
use BitWaspNew\Bitcoin\Serializer\MessageSigner\SignedMessageSerializer;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\Signature\CompactSignatureInterface;

class SignedMessage
{

    /**
     * @var string
     */
    private $message;

    /**
     * @var CompactSignatureInterface
     */
    private $compactSignature;

    /**
     * @param string $message
     * @param CompactSignatureInterface $signature
     */
    public function __construct($message, CompactSignatureInterface $signature)
    {
        $this->message = $message;
        $this->compactSignature = $signature;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return CompactSignatureInterface
     */
    public function getCompactSignature()
    {
        return $this->compactSignature;
    }

    /**
     * @return \BitWasp\Buffertools\BufferInterface
     */
    public function getBuffer()
    {
        $serializer = new SignedMessageSerializer(
            EcSerializer::getSerializer(CompactSignatureSerializerInterface::class)
        );
        return $serializer->serialize($this);
    }
}
