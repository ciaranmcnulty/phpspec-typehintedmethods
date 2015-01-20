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
        foreach ($arguments as $key => $argument){
            $argumentStrings[] = $this->getTypeHint($argument).$this->getArgName($argument);
        }
        $allCount = array_count_values($argumentStrings);
        $duplicatesCount = array_filter($allCount, function ($count) {
            return 1 < $count;
        });
        for ($i = count($argumentStrings) - 1; $i >= 0; $i--) {
            if (isset($duplicatesCount[$argumentStrings[$i]])) {
                $duplicatesCount[$argumentStrings[$i]]--;
                $argumentStrings[$i] .= $duplicatesCount[$argumentStrings[$i]] + 1;
            }
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
        if (is_object($argument)) {
            $typeHint .= '\\'.$this->classIdentifier->getTypeName($argument).' ';
        }

        return $typeHint;
    }

    /**
     * @param $argument
     * @return string
     */
    private function getArgName($argument)
    {
        if (!is_object($argument)) {
            return '$argument';
        }
        $typeHint = $this->classIdentifier->getTypeName($argument);
        $parts = explode('\\', $typeHint);
        $className = end($parts);

        return '$'.lcfirst($className);
    }
}
