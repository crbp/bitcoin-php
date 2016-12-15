<?php

namespace BitWaspNew\Bitcoin\Serializer\Transaction;

use BitWaspNew\Bitcoin\Transaction\Factory\TxBuilder;
use BitWaspNew\Buffertools\Parser;
use BitWaspNew\Bitcoin\Transaction\Transaction;
use BitWaspNew\Bitcoin\Transaction\TransactionInterface;
use BitWaspNew\Buffertools\TemplateFactory;

class OldTransactionSerializer
{
    /**
     * @var TransactionInputSerializer
     */
    public $inputSerializer;

    /**
     * @var TransactionOutputSerializer
     */
    public $outputSerializer;

    /**
     *
     */
    public function __construct()
    {
        $this->inputSerializer = new TransactionInputSerializer(new OutPointSerializer());
        $this->outputSerializer = new TransactionOutputSerializer;
    }

    /**
     * @return \BitWasp\Buffertools\Template
     */
    private function getTemplate()
    {
        return (new TemplateFactory())
            ->int32le()
            ->vector(function (Parser $parser) {
                return $this->inputSerializer->fromParser($parser);
            })
            ->vector(function (Parser $parser) {
                return $this->outputSerializer->fromParser($parser);
            })
            ->uint32le()
            ->getTemplate();
    }

    /**
     * @param TransactionInterface $transaction
     * @return string
     */
    public function serialize(TransactionInterface $transaction)
    {
        return $this->getTemplate()->write([
            $transaction->getVersion(),
            $transaction->getInputs(),
            $transaction->getOutputs(),
            $transaction->getLockTime()
        ]);
    }

    /**
     * @param Parser $parser
     * @return Transaction
     * @throws \BitWasp\Buffertools\Exceptions\ParserOutOfRange
     * @throws \Exception
     */
    public function fromParser(Parser $parser)
    {
        $p  = $this->getTemplate()->parse($parser);

        list ($nVersion, $inputArray, $outputArray, $nLockTime) = $p;

        return (new TxBuilder())
            ->version($nVersion)
            ->inputs($inputArray)
            ->outputs($outputArray)
            ->locktime($nLockTime)
            ->get();
    }

    /**
     * @param $hex
     * @return Transaction
     */
    public function parse($hex)
    {
        $parser = new Parser($hex);
        return $this->fromParser($parser);
    }
}
