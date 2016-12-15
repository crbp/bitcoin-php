<?php

namespace BitWaspNew\Bitcoin\Block;

use BitWaspNew\Bitcoin\Serializable;
use BitWaspNew\Bitcoin\Serializer\Block\BlockHeaderSerializer;
use BitWaspNew\Bitcoin\Serializer\Block\FilteredBlockSerializer;
use BitWaspNew\Bitcoin\Serializer\Block\PartialMerkleTreeSerializer;
use BitWaspNew\Buffertools\BufferInterface;

class FilteredBlock extends Serializable
{
    /**
     * @var BlockHeaderInterface
     */
    private $header;

    /**
     * @var PartialMerkleTree
     */
    private $partialTree;

    /**
     * @param BlockHeaderInterface $header
     * @param PartialMerkleTree $merkleTree
     */
    public function __construct(BlockHeaderInterface $header, PartialMerkleTree $merkleTree)
    {
        $this->header = $header;
        $this->partialTree = $merkleTree;
    }

    /**
     * @return BlockHeaderInterface
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @return PartialMerkleTree
     */
    public function getPartialTree()
    {
        return $this->partialTree;
    }

    /**
     * @return BufferInterface
     */
    public function getBuffer()
    {
        return (new FilteredBlockSerializer(new BlockHeaderSerializer(), new PartialMerkleTreeSerializer()))->serialize($this);
    }
}
