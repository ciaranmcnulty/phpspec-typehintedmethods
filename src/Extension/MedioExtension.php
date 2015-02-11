<?php

namespace Cjm\PhpSpec\Extension;

use Gnugat\Medio\PrettyPrinter;
use PhpSpec\Extension\ExtensionInterface;
use PhpSpec\ServiceContainer;

class MedioExtension implements ExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ServiceContainer $container)
    {
        $container->set('medio.pretty_printer', function ($c) {
            $factoryClass = PULI_FACTORY_CLASS;
            $factory = new $factoryClass();
            $repository = $factory->createRepository();
            $medioTemplatesPath = $repository->get('/gnugat/medio/templates')->getFilesystemPath();

            $loader = new \Twig_Loader_Filesystem($medioTemplatesPath);
            $twig = new \Twig_Environment($loader);

            return new PrettyPrinter($twig);
        });
    }
}
