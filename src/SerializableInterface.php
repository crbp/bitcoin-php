<?php

namespace BitWaspNew\Bitcoin;

use BitWaspNew\Buffertools\Buffer;

interface SerializableInterface extends \BitWasp\Buffertools\SerializableInterface
{
    /**
     * @return Buffer
     */
    public function getBuffer();

    /**
     * @return string
     */
    public function getHex();

    /**
     * @return string
     */
    public function getBinary();

    /**
     * @return string
     */
    public function getInt();
}
