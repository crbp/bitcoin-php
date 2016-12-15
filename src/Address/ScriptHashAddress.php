<?php

namespace BitWaspNew\Bitcoin\Address;

use BitWaspNew\Bitcoin\Bitcoin;
use BitWaspNew\Bitcoin\Network\NetworkInterface;
use BitWaspNew\Bitcoin\Script\ScriptFactory;
use BitWaspNew\Bitcoin\Script\ScriptInterface;

class ScriptHashAddress extends Address
{
    /**
     * @param NetworkInterface $network
     * @return string
     */
    public function getPrefixByte(NetworkInterface $network = null)
    {
        $network = $network ?: Bitcoin::getNetwork();
        return pack("H*", $network->getP2shByte());
    }

    /**
     * @return ScriptInterface
     */
    public function getScriptPubKey()
    {
        return ScriptFactory::scriptPubKey()->payToScriptHash($this->getHash());
    }
}
