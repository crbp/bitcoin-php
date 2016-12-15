<?php

namespace BitWaspNew\Bitcoin\Address;

use BitWaspNew\Bitcoin\Network\NetworkInterface;
use BitWaspNew\Bitcoin\Script\ScriptInterface;
use BitWasp\Buffertools\BufferInterface;

interface AddressInterface
{
    /**
     * @param NetworkInterface $network
     * @return string
     */
    public function getPrefixByte(NetworkInterface $network);

    /**
     * @param NetworkInterface $network
     * @return string
     */
    public function getAddress(NetworkInterface $network = null);

    /**
     * @return BufferInterface
     */
    public function getHash();

    /**
     * @return ScriptInterface
     */
    public function getScriptPubKey();
}
