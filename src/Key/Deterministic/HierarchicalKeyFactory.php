<?php

namespace BitWaspNew\Bitcoin\Key\Deterministic;

use BitWaspNew\Bitcoin\Bitcoin;
use BitWaspNew\Bitcoin\Key\PrivateKeyFactory;
use BitWasp\Buffertools\Buffer;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\Adapter\EcAdapterInterface;
use BitWaspNew\Bitcoin\Network\NetworkInterface;
use BitWaspNew\Bitcoin\Crypto\Hash;
use BitWaspNew\Bitcoin\Serializer\Key\HierarchicalKey\Base58ExtendedKeySerializer;
use BitWaspNew\Bitcoin\Serializer\Key\HierarchicalKey\ExtendedKeySerializer;
use BitWasp\Buffertools\BufferInterface;

class HierarchicalKeyFactory
{
    /**
     * @param EcAdapterInterface $ecAdapter
     * @param NetworkInterface $network
     * @return Base58ExtendedKeySerializer
     */
    public static function getSerializer(EcAdapterInterface $ecAdapter, $network = null)
    {
        $network = $network ?: Bitcoin::getNetwork();
        $extSerializer = new Base58ExtendedKeySerializer(new ExtendedKeySerializer($ecAdapter, $network));
        return $extSerializer;
    }

    /**
     * @param EcAdapterInterface|null $ecAdapter
     * @return HierarchicalKey
     */
    public static function generateMasterKey(EcAdapterInterface $ecAdapter = null)
    {
        $ecAdapter = $ecAdapter ?: Bitcoin::getEcAdapter();
        $buffer = PrivateKeyFactory::create(true, $ecAdapter);
        return self::fromEntropy($buffer->getBuffer(), $ecAdapter);
    }

    /**
     * @param BufferInterface $entropy
     * @param EcAdapterInterface $ecAdapter
     * @return HierarchicalKey
     */
    public static function fromEntropy(BufferInterface $entropy, EcAdapterInterface $ecAdapter = null)
    {
        $ecAdapter = $ecAdapter ?: Bitcoin::getEcAdapter();
        $hash = Hash::hmac('sha512', $entropy, new Buffer('Bitcoin seed', null, $ecAdapter->getMath()));

        return new HierarchicalKey(
            $ecAdapter,
            0,
            0,
            0,
            $hash->slice(32, 32),
            PrivateKeyFactory::fromHex($hash->slice(0, 32)->getHex(), true, $ecAdapter)
        );
    }

    /**
     * @param string $extendedKey
     * @param NetworkInterface $network
     * @param EcAdapterInterface $ecAdapter
     * @return HierarchicalKey
     */
    public static function fromExtended($extendedKey, NetworkInterface $network = null, EcAdapterInterface $ecAdapter = null)
    {
        $network = $network ?: Bitcoin::getNetwork();
        $extSerializer = self::getSerializer($ecAdapter ?: Bitcoin::getEcAdapter(), $network);
        return $extSerializer->parse($extendedKey);
    }
}
