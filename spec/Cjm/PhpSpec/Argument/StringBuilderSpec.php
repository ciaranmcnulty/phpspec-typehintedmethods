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

    function it_should_use_generic_name_for_non_object_argument(ClassIdentifier $classIdentifier)
    {
        $this->buildFrom(array(2))->shouldReturn('$argument');
    }

    function it_should_use_typehint__for_object_and_name_it_after_its_type(ClassIdentifier $classIdentifier)
    {
        $classIdentifier->getTypeName(Argument::any())->willReturn('ArrayObject');

        $this->buildFrom(array(new \ArrayObject()))->shouldReturn('\ArrayObject $arrayObject');
    }

    function it_should_suffix_names_when_necessary_to_avoid_name_collision(ClassIdentifier $classIdentifier)
    {
        $classIdentifier->getTypeName(Argument::any())->willReturn('ArrayObject');

        $this
            ->buildFrom(array(new \ArrayObject(), new \ArrayObject(), 1, 2))
            ->shouldReturn('\ArrayObject $arrayObject1, \ArrayObject $arrayObject2, $argument1, $argument2')
        ;
    }
}
