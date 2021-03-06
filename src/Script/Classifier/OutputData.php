<?php

namespace BitWaspNew\Bitcoin\Script\Classifier;

use BitWaspNew\Bitcoin\Script\ScriptInterface;

class OutputData
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var ScriptInterface
     */
    private $script;

    /**
     * @var mixed
     */
    private $solution;

    /**
     * OutputData constructor.
     * @param string $type
     * @param ScriptInterface $script
     * @param mixed $solution
     */
    public function __construct($type, ScriptInterface $script, $solution)
    {
        $this->type = $type;
        $this->script = $script;
        $this->solution = $solution;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return ScriptInterface
     */
    public function getScript()
    {
        return $this->script;
    }

    /**
     * @return mixed
     */
    public function getSolution()
    {
        return $this->solution;
    }

    /**
     * @return bool
     */
    public function canSign()
    {
        return in_array($this->type, [OutputClassifier::MULTISIG, OutputClassifier::PAYTOPUBKEY, OutputClassifier::PAYTOPUBKEYHASH]);
    }
}
