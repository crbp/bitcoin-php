<?php

namespace BitWaspNew\Bitcoin\Script\ScriptInfo;

use BitWaspNew\Bitcoin\Crypto\EcAdapter\Key\PublicKeyInterface;
use BitWaspNew\Bitcoin\Key\PublicKeyFactory;
use BitWaspNew\Bitcoin\Script\Opcodes;
use BitWaspNew\Bitcoin\Script\ScriptInterface;

class Multisig implements ScriptInfoInterface
{
    /**
     * @var int
     */
    private $m;

    /**
     * @var int
     */
    private $n;

    /**
     * @var PublicKeyInterface[]
     */
    private $keys = [];

    /**
     * @param ScriptInterface $script
     */
    public function __construct(ScriptInterface $script)
    {
        $publicKeys = [];
        $parse = $script->getScriptParser()->decode();
        if (count($parse) < 4 || end($parse)->getOp() !== Opcodes::OP_CHECKMULTISIG) {
            throw new \InvalidArgumentException('Malformed multisig script');
        }

        $mCode = $parse[0]->getOp();
        $nCode = $parse[count($parse) - 2]->getOp();

        $this->m = \BitWaspNew\Bitcoin\Script\decodeOpN($mCode);
        foreach (array_slice($parse, 1, -2) as $key) {
            /** @var \BitWaspNew\Bitcoin\Script\Parser\Operation $key */
            if (!$key->isPush()) {
                throw new \RuntimeException('Malformed multisig script');
            }

            $publicKeys[] = PublicKeyFactory::fromHex($key->getData());
        }

        $this->n = \BitWaspNew\Bitcoin\Script\decodeOpN($nCode);
        if ($this->n === 0 || $this->n !== count($publicKeys)) {
            throw new \LogicException('No public keys found in script');
        }

        $this->keys = $publicKeys;
    }

    /**
     * @return int
     */
    public function getRequiredSigCount()
    {
        return $this->m;
    }

    /**
     * @return int
     */
    public function getKeyCount()
    {
        return $this->n;
    }

    /**
     * @param PublicKeyInterface $publicKey
     * @return bool
     */
    public function checkInvolvesKey(PublicKeyInterface $publicKey)
    {
        $binary = $publicKey->getBinary();
        foreach ($this->keys as $key) {
            if ($key->getBinary() === $binary) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return \BitWaspNew\Bitcoin\Crypto\EcAdapter\Key\PublicKeyInterface[]
     */
    public function getKeys()
    {
        return $this->keys;
    }
}
