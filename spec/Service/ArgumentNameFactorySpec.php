<?php

namespace spec\Cjm\PhpSpec\Service;

use Gnugat\Medio\Model\Type;
use PhpSpec\ObjectBehavior;

class ArgumentNameFactorySpec extends ObjectBehavior
{
    function it_names_objects_after_their_type(Type $type)
    {
        $type->isObject()->willReturn(true);
        $type->getName()->willReturn('\\PhpSpec\\ObjectBehavior');

        $this->fromType($type)->shouldBe('objectBehavior');
    }

    function it_gives_generic_name_to_the_rest(Type $type)
    {
        $type->isObject()->willReturn(false);

        $this->fromType($type)->shouldBe('argument');
    }
}
