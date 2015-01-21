<?php

namespace spec\Cjm\PhpSpec\Argument;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ClassIdentifierSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Cjm\PhpSpec\Argument\ClassIdentifier');
    }

    function it_should_identify_objects_as_their_class()
    {
        $this->getTypeName(new \ArrayObject())->shouldReturn('ArrayObject');
    }

    function it_should_identify_prophecy_class_doubles_as_their_base_class(\ArrayObject $class)
    {
        $this->getTypeName($class)->shouldReturn('ArrayObject');
    }

    function it_should_identify_prophecy_interface_doubles_as_their_base_interface(\Iterator $interface)
    {
        $this->getTypeName($interface)->shouldReturn('Iterator');
    }

    function it_should_build_type_hints_from_prophecy_based_on_stdclass(\stdClass $stdClass)
    {
        $this->getTypeName($stdClass)->shouldReturn('stdClass');
    }
}
