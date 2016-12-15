<?php

namespace BitWaspNew\Bitcoin\Mnemonic;

use BitWaspNew\Bitcoin\Bitcoin;
use BitWaspNew\Bitcoin\Crypto\EcAdapter\Adapter\EcAdapterInterface;
use BitWaspNew\Bitcoin\Mnemonic\Bip39\Bip39Mnemonic;
use BitWaspNew\Bitcoin\Mnemonic\Bip39\Bip39WordListInterface;
use BitWaspNew\Bitcoin\Mnemonic\Electrum\ElectrumMnemonic;
use BitWaspNew\Bitcoin\Mnemonic\Electrum\ElectrumWordListInterface;

class MnemonicFactory
{

    /**
     * @param ElectrumWordListInterface $wordList
     * @param EcAdapterInterface $ecAdapter
     * @return ElectrumMnemonic
     */
    public static function electrum(ElectrumWordListInterface $wordList = null, EcAdapterInterface $ecAdapter = null)
    {
        return new ElectrumMnemonic(
            $ecAdapter ?: Bitcoin::getEcAdapter(),
            $wordList ?: new \BitWasp\Bitcoin\Mnemonic\Electrum\Wordlist\EnglishWordList()
        );
    }

    /**
     * @param \BitWasp\Bitcoin\Mnemonic\Bip39\Bip39WordListInterface $wordList
     * @param EcAdapterInterface $ecAdapter
     * @return Bip39Mnemonic
     */
    public static function bip39(Bip39WordListInterface $wordList = null, EcAdapterInterface $ecAdapter = null)
    {
        return new Bip39Mnemonic(
            $ecAdapter ?: Bitcoin::getEcAdapter(),
            $wordList ?: new Bip39\Wordlist\EnglishWordList()
        );
    }
}
