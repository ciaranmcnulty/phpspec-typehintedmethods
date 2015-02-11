<?php

namespace Cjm\PhpSpec\Extension;

use Cjm\PhpSpec\Generator\ArgumentsGenerator;
use Cjm\PhpSpec\Generator\TypeHintedMethodGenerator;
use Cjm\PhpSpec\Service\ArgumentCollectionFactory;
use Cjm\PhpSpec\Service\ArgumentNameFactory;
use Cjm\PhpSpec\Service\TypeFactory;
use PhpSpec\Extension\ExtensionInterface;
use PhpSpec\ServiceContainer;
use PhpSpec\Util\Filesystem;

class TypeHintedMethodsExtension implements ExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ServiceContainer $container)
    {
        $container->set('code_generator.generators.method', function ($c) {
            $argumentCollectionFactory = new ArgumentCollectionFactory(new ArgumentNameFactory(), new TypeFactory());

            return new TypeHintedMethodGenerator(
                $c->get('console.io'),
                $c->get('code_generator.templates'),
                new Filesystem(),
                new ArgumentsGenerator($argumentCollectionFactory, $c->get('medio.pretty_printer'))
            );
        });
    }
}
