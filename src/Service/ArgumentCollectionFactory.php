<?php

namespace Cjm\PhpSpec\Service;

use Gnugat\Medio\Model\Argument;
use Gnugat\Medio\Model\ArgumentCollection;
use Gnugat\Medio\Model\Type;

class ArgumentCollectionFactory
{
    /**
     * @var ArgumentNameFactory
     */
    private $argumentNameFactory;

    /**
     * @var TypeFactory
     */
    private $typeFactory;

    /**
     * @param ArgumentNameFactory $argumentNameFactory
     * @param TypeFactory         $typeFactory
     */
    public function __construct(ArgumentNameFactory $argumentNameFactory, TypeFactory $typeFactory)
    {
        $this->argumentNameFactory = $argumentNameFactory;
        $this->typeFactory = $typeFactory;
    }

    /**
     * @param array $variables
     *
     * @return ArgumentCollection
     */
    public function fromVariables(array $variables)
    {
        $argumentCollection = new ArgumentCollection();
        foreach ($variables as $variable) {
            $type = $this->typeFactory->fromVariable($variable);
            $name = $this->argumentNameFactory->fromType($type);
            $argumentCollection->add(new Argument($type, $name));
        }

        return $argumentCollection;
    }
}
