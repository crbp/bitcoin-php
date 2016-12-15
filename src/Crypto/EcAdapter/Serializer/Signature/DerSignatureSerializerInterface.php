<?php

namespace BitWaspNew\Bitcoin\Crypto\EcAdapter\Serializer\Signature;

use BitWaspNew\Bitcoin\Crypto\EcAdapter\Adapter\EcAdapterInterface;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\Signature\SignatureInterface;

interface DerSignatureSerializerInterface
{
    /**
     * @return EcAdapterInterface
     */
    public function getEcAdapter();

    /**
     * @param SignatureInterface $signature
     * @return \BitWasp\Buffertools\BufferInterface
     */
    public function serialize(SignatureInterface $signature);

    /**
     * @param string|\BitWasp\Buffertools\BufferInterface $data
     * @return SignatureInterface
     */
    public function parse($data);
}
