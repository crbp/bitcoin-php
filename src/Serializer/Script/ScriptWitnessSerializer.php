<?php

namespace BitWaspNew\Bitcoin\Serializer\Script;

use BitWaspNew\Bitcoin\Script\ScriptWitness;
use BitWaspNew\Bitcoin\Script\ScriptWitnessInterface;
use BitWaspNew\Buffertools\BufferInterface;
use BitWaspNew\Buffertools\Parser;
use BitWaspNew\Buffertools\TemplateFactory;

class ScriptWitnessSerializer
{

    /**
     * @param Parser $parser
     * @param $size
     * @return ScriptWitness
     */
    public function fromParser(Parser $parser, $size)
    {
        $varstring = (new TemplateFactory())->varstring()->getTemplate();
        $entries = [];

        for ($j = 0; $j < $size; $j++) {
            list ($data) = $varstring->parse($parser);
            $entries[] = $data;
        }

        return new ScriptWitness($entries);
    }

    /**
     * @param ScriptWitnessInterface $witness
     * @return BufferInterface
     */
    public function serialize(ScriptWitnessInterface $witness)
    {
        $varstring = (new TemplateFactory())->varstring()->getTemplate();
        $vector =  (new TemplateFactory())->vector(function () {
        })->getTemplate();

        $strs= [];
        foreach ($witness as $value) {
            $strs[] = $varstring->write([$value]);
        }
        return $vector->write([$strs]);
    }
}
