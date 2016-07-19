<?php

namespace Cjm\PhpSpec\Generator;

use Cjm\PhpSpec\Argument\StringBuilder;
use PhpSpec\CodeGenerator\Generator\GeneratorInterface;
use PhpSpec\CodeGenerator\TemplateRenderer;
use PhpSpec\Console\IO;
use PhpSpec\Locator\ResourceInterface;
use PhpSpec\Util\Filesystem;

class TypeHintedMethodGenerator implements GeneratorInterface
{
    /**
     * @var \PhpSpec\Console\IO
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
     * @param IO $io
     * @param TemplateRenderer $templates
     * @param Filesystem $filesystem
     * @param StringBuilder $argumentBuilder
     */
    public function __construct(IO $io, TemplateRenderer $templates, Filesystem $filesystem = null, StringBuilder $argumentBuilder)
    {
        $this->argumentBuilder = $argumentBuilder;
        $this->io = $io;
        $this->templates = $templates;
        $this->filesystem = $filesystem ?: new Filesystem;
    }

    /**
     * @param ResourceInterface $resource
     * @param string            $generation
     * @param array             $data
     *
     * @return bool
     */
    public function supports(ResourceInterface $resource, $generation, array $data)
    {
        return 'method' === $generation;
    }

    /**
     * @param ResourceInterface $resource
     * @param array $data
     *
     * @return mixed
     */
    public function generate(ResourceInterface $resource, array $data = array())
    {
        $filepath  = $resource->getSrcFilename();
        $name      = $data['name'];
        $arguments = $data['arguments'];

        $argString = $this->argumentBuilder->buildFrom($arguments);
        $argumentNamespace = $this->argumentBuilder->getNamespace($arguments);

        $values = array('%name%' => $name, '%arguments%' => $argString);
        if (!$content = $this->templates->render('method', $values)) {
            $content = $this->templates->renderString(
                $this->getTemplate(), $values
            );
        }

        $code = $this->filesystem->getFileContents($filepath);
        if ($argumentNamespace) {
            $code = preg_replace('/\nuse\s'.$argumentNamespace.';/', '', $code);
            $code = preg_replace('/namespace\s(.+);/', '$0'."\n".'use '.$argumentNamespace.';', $code);
        }

        $code = preg_replace('/}[ \n]*$/', rtrim($content) ."\n}\n", trim($code));
        $this->filesystem->putFileContents($filepath, $code);

        $this->io->writeln(sprintf(
                "\n<info>Method <value>%s::%s()</value> has been created.</info>",
                $resource->getSrcClassname(), $name
            ), 2);
    }

    /**
     * @return int
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

