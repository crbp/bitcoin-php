<?php

namespace BitWaspNew\Bitcoin\Block;

use BitWaspNew\Bitcoin\Math\Math;
use BitWaspNew\Bitcoin\Serializable;
use BitWaspNew\Bitcoin\Serializer\Block\BlockHeaderSerializer;
use BitWaspNew\Bitcoin\Serializer\Block\BlockSerializer;
use BitWaspNew\Bitcoin\Bloom\BloomFilter;
use BitWaspNew\Bitcoin\Serializer\Transaction\TransactionSerializer;
use BitWaspNew\Bitcoin\Transaction\TransactionInterface;

class Block extends Serializable implements BlockInterface
{
    /**
     * @var Math
     */
    private $math;

    /**
     * @var BlockHeaderInterface
     */
    private $header;

    /**
     * @var TransactionInterface[]
     */
    private $transactions;

    /**
     * @var MerkleRoot
     */
    private $merkleRoot;

    /**
     * @param Math $math
     * @param BlockHeaderInterface $header
     * @param TransactionInterface[] $transactions
     */
    public function __construct(Math $math, BlockHeaderInterface $header, array $transactions)
    {
        $this->math = $math;
        $this->header = $header;
        $this->transactions = array_map(function (TransactionInterface $tx) {
            return $tx;
        }, $transactions);
    }

    /**
     * {@inheritdoc}
     * @see \BitWaspNew\Bitcoin\Block\BlockInterface::getHeader()
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * {@inheritdoc}
     * @see \BitWaspNew\Bitcoin\Block\BlockInterface::getMerkleRoot()
     * @throws \BitWaspNew\Bitcoin\Exceptions\MerkleTreeEmpty
     */
    public function getMerkleRoot()
    {
        if (null === $this->merkleRoot) {
            $this->merkleRoot = new MerkleRoot($this->math, $this->getTransactions());
        }

        return $this->merkleRoot->calculateHash();
    }

    /**
     * @see \BitWaspNew\Bitcoin\Block\BlockInterface::getTransactions()
     * @return TransactionInterface[]
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * @param int $i
     * @return \BitWaspNew\Bitcoin\Transaction\TransactionInterface
     */
    public function getTransaction($i)
    {
        return $this->transactions[$i];
    }

    /**
     * @param BloomFilter $filter
     * @return FilteredBlock
     */
    public function filter(BloomFilter $filter)
    {
        $vMatch = [];
        $vHashes = [];
        foreach ($this->getTransactions() as $tx) {
            $vMatch[] = $filter->isRelevantAndUpdate($tx);
            $vHashes[] = $tx->getTxHash();
        }

        return new FilteredBlock(
            $this->getHeader(),
            PartialMerkleTree::create(count($this->getTransactions()), $vHashes, $vMatch)
        );
    }

    /**
     * {@inheritdoc}
     * @see \BitWasp\Buffertools\SerializableInterface::getBuffer()
     */
    public function getBuffer()
    {
        return (new BlockSerializer($this->math, new BlockHeaderSerializer(), new TransactionSerializer()))->serialize($this);
    }
}
