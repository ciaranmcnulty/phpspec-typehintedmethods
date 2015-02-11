<?php

namespace Cjm\PhpSpec\Generator;

use PhpSpec\CodeGenerator\Generator\GeneratorInterface;
use PhpSpec\CodeGenerator\TemplateRenderer;
use PhpSpec\Console\IO;
use PhpSpec\Locator\ResourceInterface;
use PhpSpec\Util\Filesystem;

class TypeHintedMethodGenerator implements GeneratorInterface
{
    /**
     * @var IO
     */
    private $io;

    /**
     * @var TemplateRenderer
     */
    private $templates;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var ArgumentsGenerator
     */
    private $argumentsGenerator;

    /**
     * @param IO                 $io
     * @param TemplateRenderer   $templates
     * @param Filesystem         $filesystem
     * @param ArgumentsGenerator $argumentsGenerator
     */
    public function __construct(
        IO $io,
        TemplateRenderer $templates,
        Filesystem $filesystem,
        ArgumentsGenerator $argumentsGenerator
    )
    {
        $this->io = $io;
        $this->templates = $templates;
        $this->filesystem = $filesystem;
        $this->argumentsGenerator = $argumentsGenerator;
    }

    /**
     * {@inheritDoc}
     */
    public function supports(ResourceInterface $resource, $generation, array $data)
    {
        return 'method' === $generation;
    }

    /**
     * {@inheritDoc}
     */
    public function generate(ResourceInterface $resource, array $data = array())
    {
        $filepath = $resource->getSrcFilename();
        $name = $data['name'];
        $arguments = $this->argumentsGenerator->generate($resource, array(
            'variables' => $data['arguments'],
            'length_restriction' => strlen("    public function {$data['name']}()"),
        ));

        $values = array('%name%' => $name, '%arguments%' => $arguments);
        if (!$content = $this->templates->render('method', $values)) {
            $content = $this->templates->renderString(
                $this->getTemplate(), $values
            );
        }

        $code = $this->filesystem->getFileContents($filepath);
        $code = preg_replace('/}[ \n]*$/', rtrim($content)."\n}\n", trim($code));
        $this->filesystem->putFileContents($filepath, $code);

        $this->io->writeln(sprintf(
            "\n<info>Method <value>%s::%s()</value> has been created.</info>",
            $resource->getSrcClassname(), $name
        ), 2);
    }

    /**
     * {@inheritDoc}
     */
    public function getPriority()
    {
        return 0;
    }

    /**
     * @return string
     */
    protected function getTemplate()
    {
        return file_get_contents(__FILE__, null, null, __COMPILER_HALT_OFFSET__);
    }
}
__halt_compiler();
    public function %name%(%arguments%)
    {
        // TODO: write logic here
    }
