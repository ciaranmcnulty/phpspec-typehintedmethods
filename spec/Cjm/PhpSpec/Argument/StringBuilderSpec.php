<?php

namespace spec\Cjm\PhpSpec\Argument;

use Cjm\PhpSpec\Argument\ClassIdentifier;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StringBuilderSpec extends ObjectBehavior
{
    function let(ClassIdentifier $classIdentifier)
    {
        $this->beConstructedWith($classIdentifier);
    }

    function it_should_use_generic_name_with_index_for_non_object_argument(ClassIdentifier $classIdentifier)
    {
        $this->buildFrom(array(2))->shouldReturn('$argument1');
    }

    function it_should_use_typehint_to_name_object_argument(ClassIdentifier $classIdentifier)
    {
        $classIdentifier->getTypeName(Argument::any())->willReturn('ArrayObject');

        $this->buildFrom(array(new \ArrayObject()))->shouldReturn('\ArrayObject $arrayObject');
    }
}
