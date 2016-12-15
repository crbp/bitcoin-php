<?php

namespace BitWaspNew\Bitcoin\Script;

use BitWaspNew\Bitcoin\Collection\CollectionInterface;
use BitWasp\Buffertools\SerializableInterface;

interface ScriptWitnessInterface extends CollectionInterface, SerializableInterface
{
    /**
     * @param ScriptWitnessInterface $witness
     * @return bool
     */
    public function equals(ScriptWitnessInterface $witness);
}
