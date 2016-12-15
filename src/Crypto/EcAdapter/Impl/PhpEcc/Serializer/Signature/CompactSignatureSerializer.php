<?php

namespace BitWaspNew\Bitcoin\Crypto\EcAdapter\Impl\PhpEcc\Serializer\Signature;

use BitWaspNew\Bitcoin\Crypto\EcAdapter\Impl\PhpEcc\Adapter\EcAdapter;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\Serializer\Signature\CompactSignatureSerializerInterface;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\Signature\CompactSignatureInterface;
use BitWaspNew\Buffertools\BufferInterface;
use BitWaspNew\Buffertools\Parser;
use BitWaspNew\Buffertools\Exceptions\ParserOutOfRange;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\Impl\PhpEcc\Signature\CompactSignature;
use BitWaspNew\Buffertools\TemplateFactory;

class CompactSignatureSerializer implements CompactSignatureSerializerInterface
{

    /**
     * @var EcAdapter
     */
    private $ecAdapter;

    /**
     * @param EcAdapter $adapter
     */
    public function __construct(EcAdapter $adapter)
    {
        $this->ecAdapter = $adapter;
    }

    /**
     * @return \BitWasp\Buffertools\Template
     */
    private function getTemplate()
    {
        return (new TemplateFactory())
            ->uint8()
            ->uint256()
            ->uint256()
            ->getTemplate();
    }

    /**
     * @param CompactSignature $signature
     * @return BufferInterface
     */
    private function doSerialize(CompactSignature $signature)
    {
        return $this->getTemplate()->write([
            $signature->getFlags(),
            gmp_strval($signature->getR(), 10),
            gmp_strval($signature->getS(), 10)
        ]);
    }

    /**
     * @param CompactSignatureInterface $signature
     * @return BufferInterface
     */
    public function serialize(CompactSignatureInterface $signature)
    {
        /** @var CompactSignature $signature */
        return $this->doSerialize($signature);
    }

    /**
     * @param Parser $parser
     * @return CompactSignature
     * @throws ParserOutOfRange
     */
    public function fromParser(Parser $parser)
    {
        $math = $this->ecAdapter->getMath();

        try {
            list ($byte, $r, $s) = $this->getTemplate()->parse($parser);

            $recoveryFlags = $byte - 27;
            if ($recoveryFlags < 0 || $recoveryFlags > 7) {
                throw new \InvalidArgumentException('invalid signature type');
            }

            $isCompressed = $math->cmp($math->bitwiseAnd(gmp_init($recoveryFlags), gmp_init(4)), gmp_init(0)) !== 0;
            $recoveryId = $recoveryFlags - ($isCompressed ? 4 : 0);
        } catch (ParserOutOfRange $e) {
            throw new ParserOutOfRange('Failed to extract full signature from parser');
        }

        return new CompactSignature($this->ecAdapter, gmp_init($r, 10), gmp_init($s, 10), $recoveryId, $isCompressed);
    }

    /**
     * @param $string
     * @return CompactSignature
     * @throws ParserOutOfRange
     */
    public function parse($string)
    {
        return $this->fromParser(new Parser($string, $this->ecAdapter->getMath()));
    }
}
