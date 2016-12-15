<?php

namespace BitWaspNew\Bitcoin\Serializer\Block;

use BitWaspNew\Bitcoin\Block\BlockInterface;
use BitWaspNew\Buffertools\Exceptions\ParserOutOfRange;
use BitWaspNew\Buffertools\Parser;

interface BlockSerializerInterface
{
    /**
     * @param Parser $parser
     * @return BlockInterface
     * @throws ParserOutOfRange
     */
    public function fromParser(Parser $parser);

    /**
     * @param \BitWasp\Buffertools\BufferInterface|string $string
     * @return BlockInterface
     * @throws ParserOutOfRange
     */
    public function parse($string);

    /**
     * @param BlockInterface $block
     * @return \BitWasp\Buffertools\BufferInterface
     */
    public function serialize(BlockInterface $block);
}
