<?php

namespace Cjm\PhpSpec\Generator;

use Cjm\PhpSpec\Service\ArgumentCollectionFactory;
use Gnugat\Medio\PrettyPrinter;
use PhpSpec\CodeGenerator\Generator\GeneratorInterface;
use PhpSpec\Locator\ResourceInterface;

class ArgumentsGenerator implements GeneratorInterface
{
    /**
     * @var ArgumentCollectionFactory
     */
    private $argumentCollectionFactory;

    /**
     * @var PrettyPrinter
     */
    private $prettyPrinter;

    /**
     * @param ArgumentCollectionFactory $argumentCollectionFactory
     * @param PrettyPrinter             $prettyPrinter
     */
    public function __construct(ArgumentCollectionFactory $argumentCollectionFactory, PrettyPrinter $prettyPrinter)
    {
        $this->argumentCollectionFactory = $argumentCollectionFactory;
        $this->prettyPrinter = $prettyPrinter;
    }

    /**
     * {@inheritDoc}
     */
    public function supports(ResourceInterface $resource, $generation, array $data)
    {
        return 'arguments' === $generation;
    }

    /**
     * {@inheritDoc}
     */
    public function generate(ResourceInterface $resource, array $data = array())
    {
        $argumentCollection = $this->argumentCollectionFactory->fromVariables($data['variables']);
        $parameters = array('length_restriction' => $data['length_restriction']);

        return $this->prettyPrinter->generateCode($argumentCollection, $parameters);
    }

    /**
     * {@inheritDoc}
     */
    public function getPriority()
    {
        return 0;
    }
}
