<?php

namespace BitWaspNew\Bitcoin\Script\ScriptInfo;

use BitWaspNew\Bitcoin\Key\PublicKeyFactory;
use BitWaspNew\Bitcoin\Script\Opcodes;
use BitWaspNew\Bitcoin\Script\ScriptInterface;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\Key\PublicKeyInterface;

class PayToPubkey implements ScriptInfoInterface
{
    /**
     * @var PublicKeyInterface
     */
    private $publicKey;

    /**
     * @param ScriptInterface $script
     */
    public function __construct(ScriptInterface $script)
    {
        $chunks = $script->getScriptParser()->decode();
        if (count($chunks) !== 2 || !$chunks[0]->isPush() || $chunks[1]->getOp() !== Opcodes::OP_CHECKSIG) {
            throw new \InvalidArgumentException('Malformed pay-to-pubkey script');
        }
        $this->publicKey = PublicKeyFactory::fromHex($chunks[0]->getData());
    }

    /**
     * @return int
     */
    public function getRequiredSigCount()
    {
        return 1;
    }

    /**
     * @return int
     */
    public function getKeyCount()
    {
        return 1;
    }

    /**
     * @param PublicKeyInterface $publicKey
     * @return bool
     */
    public function checkInvolvesKey(PublicKeyInterface $publicKey)
    {
        return $publicKey->getBinary() === $this->publicKey->getBinary();
    }

    /**
     * @return PublicKeyInterface[]
     */
    public function getKeys()
    {
        return [$this->publicKey];
    }
}
