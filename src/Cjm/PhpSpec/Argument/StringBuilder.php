<?php

namespace Cjm\PhpSpec\Argument;

class StringBuilder
{
    /**
     * @var ClassIdentifier
     */
    private $classIdentifier;

    /**
     * @param ClassIdentifier $classIdentifier
     */
    public function __construct(ClassIdentifier $classIdentifier)
    {
        $this->classIdentifier = $classIdentifier;
    }

    /**
     * @param array $arguments
     * @return string
     */
    public function buildFrom($arguments)
    {
        $argumentStrings = array();

        foreach ($arguments as $key=>$argument){
            $argumentStrings[] = $this->getTypeHint($argument) . $this->getArgName($key);
        }

        return join(', ', $argumentStrings);
    }

    /**
     * @param $argument
     * @return string
     */
    private function getTypeHint($argument)
    {
        $typeHint = '';

        if (is_object(($argument))) {
            $typeHint .= '\\' . $this->classIdentifier->getTypeName($argument) . ' ';
        }

        return $typeHint;
    }

    /**
     * @param $key
     * @return string
     */
    private function getArgName($key)
    {
        $argName = '$argument' . ($key + 1);

        return $argName;
    }
}
