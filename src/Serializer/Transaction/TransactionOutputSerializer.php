<?php

namespace BitWaspNew\Bitcoin\Serializer\Transaction;

use BitWasp\Buffertools\BufferInterface;
use BitWasp\Buffertools\Parser;
use BitWaspNew\Bitcoin\Script\Script;
use BitWaspNew\Bitcoin\Transaction\TransactionOutput;
use BitWaspNew\Bitcoin\Transaction\TransactionOutputInterface;
use BitWasp\Buffertools\TemplateFactory;

class TransactionOutputSerializer
{
    /**
     * @var \BitWasp\Buffertools\Template
     */
    private $template;

    public function __construct()
    {
        $this->template = $this->getTemplate();
    }

    /**
     * @return \BitWasp\Buffertools\Template
     */
    private function getTemplate()
    {
        return (new TemplateFactory())
            ->uint64le()
            ->varstring()
            ->getTemplate();
    }

    /**
     * @param TransactionOutputInterface $output
     * @return BufferInterface
     */
    public function serialize(TransactionOutputInterface $output)
    {
        return $this->template->write([
            $output->getValue(),
            $output->getScript()->getBuffer()
        ]);
    }

    /**
     * @param Parser $parser
     * @return TransactionOutput
     * @throws \BitWasp\Buffertools\Exceptions\ParserOutOfRange
     */
    public function fromParser(Parser $parser)
    {
        $parse = $this->template->parse($parser);
        /** @var int $value */
        $value = $parse[0];
        /** @var BufferInterface $scriptBuf */
        $scriptBuf = $parse[1];

        return new TransactionOutput(
            $value,
            new Script($scriptBuf)
        );
    }

    /**
     * @param string $string
     * @return TransactionOutput
     * @throws \BitWasp\Buffertools\Exceptions\ParserOutOfRange
     */
    public function parse($string)
    {
        $parser = new Parser($string);
        return $this->fromParser($parser);
    }
}
