<?php

namespace spec\Cjm\PhpSpec\Extension;

use Gnugat\Medio\PrettyPrinter;
use PhpSpec\ObjectBehavior;
use PhpSpec\ServiceContainer;
use Prophecy\Argument;

class TypeHintedMethodsExtensionSpec extends ObjectBehavior
{
    function it_is_a_phpspec_extension()
    {
        $this->shouldHaveType('PhpSpec\Extension\ExtensionInterface');
    }

    function it_registers_the_replacement_method_generator(PrettyPrinter $prettyPrinter, ServiceContainer $container)
    {
        $container->get('medio.pretty_printer')->willReturn($prettyPrinter);
        $container->set('code_generator.generators.method', Argument::any())->shouldBeCalled();

        $this->load($container);
    }
}
