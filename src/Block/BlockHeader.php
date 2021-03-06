<?php

namespace BitWaspNew\Bitcoin\Block;

use BitWaspNew\Bitcoin\Crypto\Hash;
use BitWaspNew\Bitcoin\Serializable;
use BitWaspNew\Bitcoin\Serializer\Block\BlockHeaderSerializer;
use BitWasp\Buffertools\BufferInterface;

class BlockHeader extends Serializable implements BlockHeaderInterface
{

    /**
     * @var int
     */
    private $version;

    /**
     * @var BufferInterface
     */
    private $prevBlock;

    /**
     * @var BufferInterface
     */
    private $merkleRoot;

    /**
     * @var int
     */
    private $timestamp;

    /**
     * @var int
     */
    private $bits;

    /**
     * @var int
     */
    private $nonce;

    /**
     * @param int $version
     * @param BufferInterface $prevBlock
     * @param BufferInterface $merkleRoot
     * @param int $timestamp
     * @param int $bits
     * @param int $nonce
     */
    public function __construct($version, BufferInterface $prevBlock, BufferInterface $merkleRoot, $timestamp, $bits, $nonce)
    {
        if ($prevBlock->getSize() !== 32) {
            throw new \InvalidArgumentException('BlockHeader prevBlock must be a 32-byte Buffer');
        }

        if ($merkleRoot->getSize() !== 32) {
            throw new \InvalidArgumentException('BlockHeader merkleRoot must be a 32-byte Buffer');
        }

        $this->version = $version;
        $this->prevBlock = $prevBlock;
        $this->merkleRoot = $merkleRoot;
        $this->timestamp = $timestamp;
        $this->bits = $bits;
        $this->nonce = $nonce;
    }

    /**
     * @return BufferInterface
     */
    public function getHash()
    {
        return Hash::sha256d($this->getBuffer())->flip();
    }

    /**
     * Get the version for this block
     *
     * {@inheritdoc}
     * @see \BitWaspNew\Bitcoin\Block\BlockHeaderInterface::getVersion()
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * {@inheritdoc}
     * @see \BitWaspNew\Bitcoin\Block\BlockHeaderInterface::getPrevBlock()
     */
    public function getPrevBlock()
    {
        return $this->prevBlock;
    }

    /**
     * {@inheritdoc}
     * @see \BitWaspNew\Bitcoin\Block\BlockHeaderInterface::getMerkleRoot()
     */
    public function getMerkleRoot()
    {
        return $this->merkleRoot;
    }

    /**
     * {@inheritdoc}
     * @see \BitWaspNew\Bitcoin\Block\BlockHeaderInterface::getBits()
     */
    public function getBits()
    {
        return $this->bits;
    }

    /**
     * {@inheritdoc}
     * @see \BitWaspNew\Bitcoin\Block\BlockHeaderInterface::getNonce()
     */
    public function getNonce()
    {
        return $this->nonce;
    }

    /**
     * Get the timestamp for this block
     *
     * {@inheritdoc}
     * @see \BitWaspNew\Bitcoin\Block\BlockHeaderInterface::getTimestamp()
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param BlockHeaderInterface $other
     * @return bool
     */
    public function equals(BlockHeaderInterface $other)
    {
        return $this->version === $other->getVersion()
            && $this->prevBlock->equals($other->getPrevBlock())
            && $this->merkleRoot->equals($other->getMerkleRoot())
            && $this->timestamp === $other->getTimestamp()
            && $this->bits === $other->getBits()
            && $this->nonce === $other->getNonce();
    }

    /**
     * {@inheritdoc}
     * @see \BitWasp\Buffertools\SerializableInterface::getBuffer()
     */
    public function getBuffer()
    {
        return (new BlockHeaderSerializer())->serialize($this);
    }
}
