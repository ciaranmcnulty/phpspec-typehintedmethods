<?php

namespace Cjm\PhpSpec\Generator;

use Cjm\PhpSpec\Argument\StringBuilder;
use PhpSpec\CodeGenerator\Generator\Generator;
use PhpSpec\CodeGenerator\TemplateRenderer;
use PhpSpec\Console\ConsoleIO;
use PhpSpec\Locator\Resource;
use PhpSpec\Util\Filesystem;

class TypeHintedMethodGenerator implements Generator
{
    /**
     * @var \PhpSpec\Console\ConsoleIO
     */
    private $io;

    /**
     * @var \PhpSpec\CodeGenerator\TemplateRenderer
     */
    private $templates;

    /**
     * @var \PhpSpec\Util\Filesystem
     */
    private $filesystem;

    /**
     * @var \Cjm\PhpSpec\Argument\StringBuilder
     */
    private $argumentBuilder;

    /**
     * @param ConsoleIO $io
     * @param TemplateRenderer $templates
     * @param Filesystem $filesystem
     * @param StringBuilder $argumentBuilder
     */
    public function __construct(ConsoleIO $io, TemplateRenderer $templates, Filesystem $filesystem = null, StringBuilder $argumentBuilder)
    {
        $this->argumentBuilder = $argumentBuilder;
        $this->io = $io;
        $this->templates = $templates;
        $this->filesystem = $filesystem ?: new Filesystem;
    }

    public function supports(Resource $resource, string $generation, array $data) : bool
    {
        return 'method' === $generation;
    }

    /**
     * @param Resource $resource
     * @param array $data
     *
     * @return mixed
     */
    public function generate(Resource $resource, array $data = array()) : void
    {
        $filepath  = $resource->getSrcFilename();
        $name      = $data['name'];
        $arguments = $data['arguments'];

        $argString = $this->argumentBuilder->buildFrom($arguments);

        $values = array('%name%' => $name, '%arguments%' => $argString);
        if (!$content = $this->templates->render('method', $values)) {
            $content = $this->templates->renderString(
                $this->getTemplate(), $values
            );
        }

        $code = $this->filesystem->getFileContents($filepath);
        $code = preg_replace('/}[ \n]*$/', rtrim($content) ."\n}\n", trim($code));
        $this->filesystem->putFileContents($filepath, $code);

        $this->io->writeln(sprintf(
                "\n<info>Method <value>%s::%s()</value> has been created.</info>",
                $resource->getSrcClassname(), $name
            ), 2);
    }

    public function getPriority() : int
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

