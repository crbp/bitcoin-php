<?php

namespace BitWaspNew\Bitcoin\Serializer\Bloom;

use BitWaspNew\Bitcoin\Bitcoin;
use BitWaspNew\Bitcoin\Math\Math;
use BitWaspNew\Bitcoin\Bloom\BloomFilter;
use BitWaspNew\Buffertools\Buffer;
use BitWaspNew\Buffertools\BufferInterface;
use BitWaspNew\Buffertools\Parser;
use BitWaspNew\Buffertools\TemplateFactory;

class BloomFilterSerializer
{
    /**
     * @return \BitWasp\Buffertools\Template
     */
    public function getTemplate()
    {
        return (new TemplateFactory())
            ->vector(function (Parser $parser) {
                return $parser->readBytes(1)->getInt();
            })
            ->uint32le()
            ->uint32le()
            ->uint8()
            ->getTemplate();
    }

    /**
     * @param BloomFilter $filter
     * @return BufferInterface
     */
    public function serialize(BloomFilter $filter)
    {
        $math = new Math();

        $vBuf = [];
        foreach ($filter->getData() as $i) {
            $vBuf[] = Buffer::int($i, 1, $math);
        }

        return $this->getTemplate()->write([
            $vBuf,
            $filter->getNumHashFuncs(),
            $filter->getTweak(),
            (string) $filter->getFlags()
        ]);
    }

    /**
     * @param Parser $parser
     * @return BloomFilter
     */
    public function fromParser(Parser $parser)
    {
        list ($vData, $numHashFuncs, $nTweak, $flags) = $this->getTemplate()->parse($parser);

        return new BloomFilter(
            Bitcoin::getMath(),
            $vData,
            $numHashFuncs,
            $nTweak,
            $flags
        );
    }

    /**
     * @param $data
     * @return BloomFilter
     */
    public function parse($data)
    {
        return $this->fromParser(new Parser($data));
    }
}
