<?php

namespace BitWaspNew\Bitcoin\Script;

use BitWaspNew\Bitcoin\Collection\StaticBufferCollection;
use BitWaspNew\Bitcoin\Serializer\Script\ScriptWitnessSerializer;

class ScriptWitness extends StaticBufferCollection implements ScriptWitnessInterface
{
    /**
     * @param ScriptWitnessInterface $witness
     * @return bool
     */
    public function equals(ScriptWitnessInterface $witness)
    {
        $nStack = count($this);
        if ($nStack !== count($witness)) {
            return false;
        }

        for ($i = 0; $i < $nStack; $i++) {
            if (false === $this->offsetGet($i)->equals($witness->offsetGet($i))) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return \BitWasp\Buffertools\BufferInterface
     */
    public function getBuffer()
    {
        return (new ScriptWitnessSerializer())->serialize($this);
    }
}
