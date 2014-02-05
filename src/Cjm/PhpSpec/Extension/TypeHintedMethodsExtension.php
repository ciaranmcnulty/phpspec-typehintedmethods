<?php

namespace Cjm\PhpSpec\Extension;

use Cjm\PhpSpec\Argument\ClassIdentifier;
use Cjm\PhpSpec\Argument\StringBuilder;
use Cjm\PhpSpec\Generator\TypeHintedMethodGenerator;
use PhpSpec\Extension\ExtensionInterface;
use PhpSpec\ServiceContainer;

class TypeHintedMethodsExtension implements ExtensionInterface
{
    /**
     * @param ServiceContainer $container
     */
    public function load(ServiceContainer $container)
    {
        $container->set('code_generator.generators.method.classidentifier', function ($c) {
            return new ClassIdentifier();
        });

        $container->set('code_generator.generators.method.argumentbuilder', function ($c) {
            return new StringBuilder($c->get('code_generator.generators.method.classidentifier'));
        });

        $container->set('code_generator.generators.method', function ($c) {
            return new TypeHintedMethodGenerator(
                $c->get('console.io'),
                $c->get('code_generator.templates'),
                null,
                $c->get('code_generator.generators.method.argumentbuilder')
            );
        });
    }
}
