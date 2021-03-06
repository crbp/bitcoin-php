<?php

namespace BitWaspNew\Bitcoin\Mnemonic\Bip39;

use BitWaspNew\Bitcoin\Crypto\Hash;
use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\BufferInterface;

class Bip39SeedGenerator
{
    /**
     * @param string $string
     * @return BufferInterface
     * @throws \Exception
     */
    private function normalize($string)
    {
        if (!class_exists('Normalizer')) {
            if (mb_detect_encoding($string) === 'UTF-8') {
                throw new \Exception('UTF-8 passphrase is not supported without the PECL intl extension installed.');
            } else {
                return new Buffer($string);
            }
        }

        return new Buffer(\Normalizer::normalize($string, \Normalizer::FORM_KD));
    }

    /**
     * @param string $mnemonic
     * @param string $passphrase
     * @return \BitWasp\Buffertools\BufferInterface
     * @throws \Exception
     */
    public function getSeed($mnemonic, $passphrase = '')
    {
        return Hash::pbkdf2(
            'sha512',
            $this->normalize($mnemonic),
            $this->normalize("mnemonic" . $passphrase),
            2048,
            64
        );
    }
}
