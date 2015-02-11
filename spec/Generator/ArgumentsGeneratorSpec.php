<?php

namespace spec\Cjm\PhpSpec\Generator;

use Cjm\PhpSpec\Service\ArgumentCollectionFactory;
use Gnugat\Medio\Model\ArgumentCollection;
use Gnugat\Medio\PrettyPrinter;
use PhpSpec\Locator\ResourceInterface;
use PhpSpec\ObjectBehavior;

class ArgumentsGeneratorSpec extends ObjectBehavior
{
    const VARIABLE = 'string';
    const LENGTH_RESTRICTION = 0;

    function let(ArgumentCollectionFactory $argumentCollectionFactory, PrettyPrinter $prettyPrinter)
    {
        $this->beConstructedWith($argumentCollectionFactory, $prettyPrinter);
    }

    function it_is_a_phpspec_generator()
    {
        $this->shouldImplement('PhpSpec\CodeGenerator\Generator\GeneratorInterface');
    }

    function it_supports_arguments_generation(ResourceInterface $resource)
    {
        $this->supports($resource, 'arguments', array())->shouldBe(true);
    }

    function it_has_no_specific_priority()
    {
        $this->getPriority()->shouldBe(0);
    }

    function it_generates_arguments(
        ArgumentCollectionFactory $argumentCollectionFactory,
        ArgumentCollection $argumentCollection,
        PrettyPrinter $prettyPrinter,
        ResourceInterface $resource
    )
    {
        $variables = array(self::VARIABLE);
        $data = array('variables' => $variables, 'length_restriction' => self::LENGTH_RESTRICTION);

        $argumentCollectionFactory->fromVariables($variables)->willReturn($argumentCollection);
        $prettyPrinter->generateCode($argumentCollection, array('length_restriction' => self::LENGTH_RESTRICTION))->willReturn('');

        $this->generate($resource, $data);
    }
}
