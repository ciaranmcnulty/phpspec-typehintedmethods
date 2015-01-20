<?php

namespace spec\Cjm\PhpSpec\Argument;

use Cjm\PhpSpec\Argument\ClassIdentifier;
use Cjm\PhpSpec\Argument\StringBuilder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StringBuilderSpec extends ObjectBehavior
{
    function let(ClassIdentifier $classIdentifier)
    {
        $this->beConstructedWith($classIdentifier);
    }

    function it_should_use_type_hints_from_class_identifier(ClassIdentifier $classIdentifier)
    {
        $classIdentifier->getTypeName(Argument::any())->willReturn('ArrayObject');

        $this->buildFrom(array(new \ArrayObject(), 2))->shouldReturn('\ArrayObject $arrayObject, $argument2');
    }
}
