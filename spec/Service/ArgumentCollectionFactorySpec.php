<?php

namespace spec\Cjm\PhpSpec\Service;

use Cjm\PhpSpec\Service\ArgumentNameFactory;
use Cjm\PhpSpec\Service\TypeFactory;
use Gnugat\Medio\Model\Type;
 use PhpSpec\ObjectBehavior;

class ArgumentCollectionFactorySpec extends ObjectBehavior
{
    const VARIABLE = 'string';

    function let(ArgumentNameFactory $argumentNameFactory, TypeFactory $typeFactory)
    {
        $this->beConstructedWith($argumentNameFactory, $typeFactory);
    }

    function it_makes_argument_collection_from_variables(
        ArgumentNameFactory $argumentNameFactory,
        Type $type,
        TypeFactory $typeFactory
    )
    {
        $variables = array(self::VARIABLE);
        $typeFactory->fromVariable(self::VARIABLE)->willReturn($type);
        $argumentNameFactory->fromType($type)->willReturn('argument');

        $this->fromVariables($variables);
    }
}
