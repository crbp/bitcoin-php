<?php

namespace BitWaspNew\Bitcoin\Crypto\EcAdapter\Impl\Secp256k1\Serializer\Key;

use BitWaspNew\Bitcoin\Crypto\EcAdapter\Impl\Secp256k1\Adapter\EcAdapter;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\Impl\Secp256k1\Key\PrivateKey;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\Key\PrivateKeyInterface;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\Serializer\Key\PrivateKeySerializerInterface;
use BitWaspNew\Buffertools\Buffer;
use BitWaspNew\Buffertools\BufferInterface;
use BitWaspNew\Buffertools\Parser;

/**
 * Private Key Serializer - specific to secp256k1
 */
class PrivateKeySerializer implements PrivateKeySerializerInterface
{
    /**
     * @var bool
     */
    private $haveNextCompressed = false;

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
     * @param PrivateKey $privateKey
     * @return BufferInterface
     */
    private function doSerialize(PrivateKey $privateKey)
    {
        return new Buffer($privateKey->getSecretBinary(), 32, $this->ecAdapter->getMath());
    }

    /**
     * @param PrivateKeyInterface $privateKey
     * @return BufferInterface
     */
    public function serialize(PrivateKeyInterface $privateKey)
    {
        /** @var PrivateKey $privateKey */
        return $this->doSerialize($privateKey);
    }

    /**
     * Tells the serializer the next key to be parsed should be compressed.
     *
     * @return $this
     */
    public function setNextCompressed()
    {
        $this->haveNextCompressed = true;
        return $this;
    }

    /**
     * @param Parser $parser
     * @return PrivateKey
     * @throws \BitWasp\Buffertools\Exceptions\ParserOutOfRange
     */
    public function fromParser(Parser $parser)
    {
        $compressed = $this->haveNextCompressed;
        $this->haveNextCompressed = false;

        return $this->ecAdapter->getPrivateKey(
            gmp_init($parser->readBytes(32)->getHex(), 16),
            $compressed
        );
    }

    /**
     * @param \BitWasp\Buffertools\BufferInterface|string $data
     * @return PrivateKey
     */
    public function parse($data)
    {
        return $this->fromParser(new Parser($data, $this->ecAdapter->getMath()));
    }
}
