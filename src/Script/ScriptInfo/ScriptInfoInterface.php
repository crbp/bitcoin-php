<?php

namespace BitWaspNew\Bitcoin\Script\ScriptInfo;

use BitWaspNew\Bitcoin\Crypto\EcAdapter\Key\PublicKeyInterface;

interface ScriptInfoInterface
{
    /**
     * @return integer
     */
    public function getRequiredSigCount();

    /**
     * @return integer
     */
    public function getKeyCount();

    /**
     * @param PublicKeyInterface $publicKey
     * @return bool
     */
    public function checkInvolvesKey(PublicKeyInterface $publicKey);

    /**
     * @return PublicKeyInterface[]
     */
    public function getKeys();
}
