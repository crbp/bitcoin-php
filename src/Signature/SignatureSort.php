<?php

namespace BitWaspNew\Bitcoin\Signature;

use BitWaspNew\Bitcoin\Bitcoin;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\Adapter\EcAdapterInterface;
use BitWasp\Buffertools\BufferInterface;

class SignatureSort implements SignatureSortInterface
{
    /**
     * @var EcAdapterInterface
     */
    private $ecAdapter;

    /**
     * SignatureSort constructor.
     * @param EcAdapterInterface $ecAdapter
     */
    public function __construct(EcAdapterInterface $ecAdapter = null)
    {
        $this->ecAdapter = $ecAdapter ?: Bitcoin::getEcAdapter();
    }

    /**
     * @param \BitWaspNew\Bitcoin\Crypto\EcAdapter\Signature\SignatureInterface[] $signatures
     * @param \BitWaspNew\Bitcoin\Crypto\EcAdapter\Key\PublicKeyInterface[] $publicKeys
     * @param BufferInterface $messageHash
     * @return \SplObjectStorage
     */
    public function link(array $signatures, array $publicKeys, BufferInterface $messageHash)
    {
        $sigCount = count($signatures);
        $storage = new \SplObjectStorage();
        foreach ($signatures as $signature) {
            foreach ($publicKeys as $key) {
                if ($this->ecAdapter->verify($messageHash, $key, $signature)) {
                    $storage->attach($key, $signature);
                    if (count($storage) === $sigCount) {
                        break 2;
                    }

                    break;
                }
            }
        }

        return $storage;
    }
}
