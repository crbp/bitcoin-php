<?php

namespace BitWaspNew\Bitcoin\Serializer\Block;

use BitWaspNew\Bitcoin\Block\Block;
use BitWaspNew\Bitcoin\Serializer\Transaction\TransactionSerializerInterface;
use BitWaspNew\Buffertools\Buffertools;
use BitWaspNew\Buffertools\Exceptions\ParserOutOfRange;
use BitWaspNew\Bitcoin\Math\Math;
use BitWaspNew\Buffertools\Parser;
use BitWaspNew\Bitcoin\Block\BlockInterface;
use BitWaspNew\Buffertools\TemplateFactory;

class BlockSerializer implements BlockSerializerInterface
{
    /**
     * @var Math
     */
    private $math;

    /**
     * @var BlockHeaderSerializer
     */
    private $headerSerializer;

    /**
     * @var TransactionSerializerInterface
     */
    private $txSerializer;

    /**
     * @var \BitWasp\Buffertools\Template
     */
    private $txsTemplate;

    /**
     * @param Math $math
     * @param BlockHeaderSerializer $headerSerializer
     * @param TransactionSerializerInterface $txSerializer
     */
    public function __construct(Math $math, BlockHeaderSerializer $headerSerializer, TransactionSerializerInterface $txSerializer)
    {
        $this->math = $math;
        $this->headerSerializer = $headerSerializer;
        $this->txSerializer = $txSerializer;
        $this->txsTemplate = $this->getTxsTemplate();
    }

    /**
     * @return \BitWasp\Buffertools\Template
     */
    private function getTxsTemplate()
    {
        return (new TemplateFactory())
            ->vector(function (Parser $parser) {
                return $this->txSerializer->fromParser($parser);
            })
            ->getTemplate();
    }

    /**
     * @param Parser $parser
     * @return BlockInterface
     * @throws ParserOutOfRange
     */
    public function fromParser(Parser $parser)
    {
        try {
            return new Block(
                $this->math,
                $this->headerSerializer->fromParser($parser),
                $this->txsTemplate->parse($parser)[0]
            );
        } catch (ParserOutOfRange $e) {
            throw new ParserOutOfRange('Failed to extract full block header from parser');
        }
    }

    /**
     * @param \BitWasp\Buffertools\BufferInterface|string $string
     * @return BlockInterface
     * @throws ParserOutOfRange
     */
    public function parse($string)
    {
        return $this->fromParser(new Parser($string));
    }

    /**
     * @param BlockInterface $block
     * @return \BitWasp\Buffertools\BufferInterface
     */
    public function serialize(BlockInterface $block)
    {
        return Buffertools::concat(
            $this->headerSerializer->serialize($block->getHeader()),
            $this->txsTemplate->write([$block->getTransactions()])
        );
    }
}
