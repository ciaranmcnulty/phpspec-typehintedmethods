<?php

namespace spec\Cjm\PhpSpec\Extension;

use PhpSpec\CodeGenerator\Generator\MethodGenerator;
use PhpSpec\ObjectBehavior;
use PhpSpec\ServiceContainer;
use Prophecy\Argument;

class TypeHintedMethodsExtensionSpec extends ObjectBehavior
{
    function it_is_a_phpspec_extension()
    {
        $this->shouldHaveType('PhpSpec\Extension\ExtensionInterface');
    }

    function it_registers_the_replacement_method_generator(ServiceContainer $container)
    {
        $this->load($container);

        $container->set('code_generator.generators.method', Argument::any())->shouldHaveBeenCalled();
    }
}
