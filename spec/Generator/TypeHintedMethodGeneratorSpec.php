<?php

namespace spec\Cjm\PhpSpec\Generator;

use Cjm\PhpSpec\Generator\ArgumentsGenerator;
use Gnugat\Medio\Model\ArgumentCollection;
use Gnugat\Medio\PrettyPrinter;
use PhpSpec\CodeGenerator\TemplateRenderer;
use PhpSpec\Console\IO;
use PhpSpec\Locator\ResourceInterface;
use PhpSpec\ObjectBehavior;
use PhpSpec\Util\Filesystem;

class TypeHintedMethodGeneratorSpec extends ObjectBehavior
{
    const NAME = '__construct';
    const ARGUMENT = 'string';
    const LENGTH_RESTRICTION = 33;

    function let(
        ArgumentsGenerator $argumentsGenerator,
        Filesystem $filesystem,
        IO $io,
        TemplateRenderer $templateRenderer
    )
    {
        $this->beConstructedWith($io, $templateRenderer, $filesystem, $argumentsGenerator);
    }

    function it_is_a_phpspec_generator()
    {
        $this->shouldImplement('PhpSpec\CodeGenerator\Generator\GeneratorInterface');
    }

    function it_supports_method_generation(ResourceInterface $resource)
    {
        $this->supports($resource, 'method', array())->shouldBe(true);
    }

    function it_has_no_specific_priority()
    {
        $this->getPriority()->shouldBe(0);
    }

    function it_generates_method(
        ArgumentsGenerator $argumentsGenerator,
        ResourceInterface $resource
    )
    {
        $arguments = array(self::ARGUMENT);
        $data = array('name' => self::NAME, 'arguments' => $arguments);
        $argumentsData = array('variables' => $arguments, 'length_restriction' => self::LENGTH_RESTRICTION);

        $argumentsGenerator->generate($resource, $argumentsData)->willReturn('$argument');

        $this->generate($resource, $data);
    }
}
