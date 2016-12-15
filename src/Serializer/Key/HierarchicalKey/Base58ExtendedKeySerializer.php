<?php

namespace BitWaspNew\Bitcoin\Serializer\Key\HierarchicalKey;

use BitWaspNew\Bitcoin\Base58;
use BitWaspNew\Bitcoin\Key\Deterministic\HierarchicalKey;

class Base58ExtendedKeySerializer
{
    /**
     * @var ExtendedKeySerializer
     */
    private $serializer;

    /**
     * @param ExtendedKeySerializer $hexSerializer
     */
    public function __construct(ExtendedKeySerializer $hexSerializer)
    {
        $this->serializer = $hexSerializer;
    }

    /**
     * @param HierarchicalKey $key
     * @return string
     */
    public function serialize(HierarchicalKey $key)
    {
        return Base58::encodeCheck($this->serializer->serialize($key));
    }

    /**
     * @param string $base58
     * @return HierarchicalKey
     * @throws \BitWaspNew\Bitcoin\Exceptions\Base58ChecksumFailure
     */
    public function parse($base58)
    {
        return $this->serializer->parse(Base58::decodeCheck($base58));
    }
}
