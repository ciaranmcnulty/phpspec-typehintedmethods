<?php

namespace spec\Cjm\PhpSpec\Service;

use ArrayObject;
use PhpSpec\ObjectBehavior;

class TypeFactorySpec extends ObjectBehavior
{
    function it_makes_an_object_from_variable()
    {
        $object = new \DateTime();

        $type = $this->fromVariable($object);

        $type->getName()->shouldBe('\DateTime');
        $type->isObject()->shouldBe(true);
    }

    function it_makes_an_object_from_prophecy_double(ArrayObject $arrayObject)
    {
        $type = $this->fromVariable($arrayObject);

        $type->getName()->shouldBe('\ArrayObject');
        $type->isObject()->shouldBe(true);
    }

    function it_makes_an_array_from_variable()
    {
        $array = array();

        $type = $this->fromVariable($array);

        $type->getName()->shouldBe('array');
        $type->isObject()->shouldBe(false);
    }

    function it_makes_a_callable_from_variable()
    {
        $callable = function() {};

        $type = $this->fromVariable($callable);

        $type->getName()->shouldBe('callable');
        $type->isObject()->shouldBe(false);
    }

    function it_makes_a_string_from_variable()
    {
        $string = 'Nobody expects the spanish inquisition!';

        $type = $this->fromVariable($string);

        $type->getName()->shouldBe('string');
        $type->isObject()->shouldBe(false);
    }

    function it_makes_a_boolean_from_variable()
    {
        $boolean = true;

        $type = $this->fromVariable($boolean);

        $type->getName()->shouldBe('bool');
        $type->isObject()->shouldBe(false);
    }

    function it_makes_a_resource_from_variable()
    {
        $resource = fopen('/dev/null', 'r');

        $type = $this->fromVariable($resource);
        fclose($resource);

        $type->getName()->shouldBe('resource');
        $type->isObject()->shouldBe(false);
    }

    function it_makes_an_integer_from_variable()
    {
        $integer = 42;

        $type = $this->fromVariable($integer);

        $type->getName()->shouldBe('int');
        $type->isObject()->shouldBe(false);
    }

    function it_makes_a_double_from_variable()
    {
        $double = 3.14;

        $type = $this->fromVariable($double);

        $type->getName()->shouldBe('double');
        $type->isObject()->shouldBe(false);
    }

    function it_makes_null_from_variable()
    {
        $null = null;

        $type = $this->fromVariable($null);

        $type->getName()->shouldBe('null');
        $type->isObject()->shouldBe(false);
    }
}
